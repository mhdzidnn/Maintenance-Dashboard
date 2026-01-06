<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProxmoxApiService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $verifySSL;
    protected $ticket;
    protected $csrfToken;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('PROXMOX_HOST', 'https://e603f83f-ac54-41de-bc20-d926691b39f8.cfargotunnel.com'), '/');
        $this->username = env('PROXMOX_USERNAME', 'root@pam');
        $this->password = env('PROXMOX_PASSWORD', '');
        $this->verifySSL = env('PROXMOX_VERIFY_SSL', false);
    }

    /**
     * Authenticate with Proxmox API
     */
    public function authenticate()
    {
        try {
            $response = Http::withOptions([
                'verify' => $this->verifySSL
            ])->post("{$this->baseUrl}/api2/json/access/ticket", [
                'username' => $this->username,
                'password' => $this->password
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->ticket = $data['data']['ticket'] ?? null;
                $this->csrfToken = $data['data']['CSRFPreventionToken'] ?? null;
                
                Log::info('Proxmox authentication successful');
                return true;
            }

            Log::error('Proxmox authentication failed', ['response' => $response->body()]);
            return false;
        } catch (\Exception $e) {
            Log::error('Proxmox authentication exception', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Make authenticated request to Proxmox API
     */
    protected function makeRequest($method, $endpoint)
    {
        if (!$this->ticket) {
            if (!$this->authenticate()) {
                return null;
            }
        }

        try {
            $response = Http::withOptions([
                'verify' => $this->verifySSL
            ])->withHeaders([
                'Cookie' => "PVEAuthCookie={$this->ticket}",
                'CSRFPreventionToken' => $this->csrfToken
            ])->$method("{$this->baseUrl}/api2/json/{$endpoint}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Proxmox API request failed', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Proxmox API request exception', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get list of nodes
     */
    public function getNodes()
    {
        $response = $this->makeRequest('get', 'nodes');
        return $response['data'] ?? [];
    }

    /**
     * Get all VMs from all nodes
     */
    public function getAllVMs()
    {
        $nodes = $this->getNodes();
        $allVMs = [];

        foreach ($nodes as $node) {
            $nodeName = $node['node'];
            $vms = $this->getNodeVMs($nodeName);
            
            foreach ($vms as $vm) {
                $allVMs[] = array_merge($vm, ['node' => $nodeName]);
            }
        }

        return $allVMs;
    }

    /**
     * Get VMs from specific node
     */
    public function getNodeVMs($nodeName)
    {
        $response = $this->makeRequest('get', "nodes/{$nodeName}/qemu");
        return $response['data'] ?? [];
    }

    /**
     * Get VM status and details
     */
    public function getVMStatus($nodeName, $vmId)
    {
        $response = $this->makeRequest('get', "nodes/{$nodeName}/qemu/{$vmId}/status/current");
        return $response['data'] ?? [];
    }

    /**
     * Parse VM data to database format
     */
    public function parseVMData($vmData, $nodeName = null)
    {
        // Get detailed status if node is provided
        $status = [];
        if ($nodeName && isset($vmData['vmid'])) {
            $status = $this->getVMStatus($nodeName, $vmData['vmid']);
        }

        // Calculate percentages
        $cpuUsagePercent = isset($vmData['cpu']) ? round($vmData['cpu'] * 100, 2) : 0;
        
        $memTotal = $vmData['maxmem'] ?? ($status['maxmem'] ?? 4294967296); // Default 4GB
        $memUsed = $vmData['mem'] ?? ($status['mem'] ?? 0);
        $memoryUsagePercent = $memTotal > 0 ? round(($memUsed / $memTotal) * 100, 2) : 0;

        return [
            'vm_id' => (string)($vmData['vmid'] ?? $vmData['id'] ?? 0),
            'name' => $vmData['name'] ?? 'Unknown VM',
            'usage_gb' => isset($vmData['maxdisk']) ? round($vmData['maxdisk'] / 1073741824, 2) : 100,
            'cpu_cores' => $vmData['cpus'] ?? ($status['cpus'] ?? 2),
            'cpu_usage_percent' => $cpuUsagePercent,
            'memory_total_mb' => round($memTotal / 1048576), // Convert to MB
            'memory_used_mb' => round($memUsed / 1048576), // Convert to MB
            'memory_usage_percent' => $memoryUsagePercent,
            'uptime_seconds' => $vmData['uptime'] ?? ($status['uptime'] ?? null),
            'is_running' => ($vmData['status'] ?? 'stopped') === 'running',
            'status' => $vmData['status'] ?? 'stopped',
            'os_type' => $this->detectOSType($vmData),
            'last_synced_at' => now()
        ];
    }

    /**
     * Detect OS type from VM data
     */
    protected function detectOSType($vmData)
    {
        $name = strtolower($vmData['name'] ?? '');
        
        if (str_contains($name, 'windows') || str_contains($name, 'win10') || str_contains($name, 'win11')) {
            return 'Windows';
        } elseif (str_contains($name, 'ubuntu') || str_contains($name, 'debian') || str_contains($name, 'linux')) {
            return 'Linux';
        }
        
        return 'Other';
    }

    /**
     * Test connection to Proxmox
     */
    public function testConnection()
    {
        try {
            $authenticated = $this->authenticate();
            
            if (!$authenticated) {
                return [
                    'success' => false,
                    'message' => 'Authentication failed. Check your credentials.'
                ];
            }

            $nodes = $this->getNodes();
            
            return [
                'success' => true,
                'message' => 'Connection successful!',
                'nodes_count' => count($nodes),
                'nodes' => $nodes
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }
}
