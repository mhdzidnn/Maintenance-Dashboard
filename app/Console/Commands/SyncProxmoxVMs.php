<?php

namespace App\Console\Commands;

use App\Models\Node;
use App\Models\VirtualMachine;
use App\Services\ProxmoxApiService;
use Illuminate\Console\Command;

class SyncProxmoxVMs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxmox:sync-vms {--test : Test connection only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Virtual Machines data from Proxmox API';

    protected $proxmoxApi;

    public function __construct(ProxmoxApiService $proxmoxApi)
    {
        parent::__construct();
        $this->proxmoxApi = $proxmoxApi;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Proxmox VM sync...');

        // Test connection if --test flag is provided
        if ($this->option('test')) {
            return $this->testConnection();
        }

        try {
            // Get all VMs from Proxmox
            $this->info('Fetching VMs from Proxmox API...');
            $vms = $this->proxmoxApi->getAllVMs();

            if (empty($vms)) {
                $this->warn('No VMs found from Proxmox API.');
                return Command::FAILURE;
            }

            $this->info('Found ' . count($vms) . ' VMs');

            $synced = 0;
            $errors = 0;

            foreach ($vms as $vmData) {
                try {
                    $nodeName = $vmData['node'] ?? 'pve';
                    
                    // Get or create node
                    $node = Node::firstOrCreate(
                        ['name' => $nodeName],
                        [
                            'name' => $nodeName,
                            'status' => 'healthy',
                            'uptime_days' => 0,
                            'uptime_percentage' => 0
                        ]
                    );

                    // Parse VM data
                    $parsedData = $this->proxmoxApi->parseVMData($vmData, $nodeName);
                    $parsedData['node_id'] = $node->id;

                    // Update or create VM
                    VirtualMachine::updateOrCreate(
                        [
                            'vm_id' => $parsedData['vm_id'],
                            'node_id' => $node->id
                        ],
                        $parsedData
                    );

                    $this->line("✓ Synced VM: {$parsedData['name']} (ID: {$parsedData['vm_id']})");
                    $synced++;
                } catch (\Exception $e) {
                    $this->error("✗ Error syncing VM: " . $e->getMessage());
                    $errors++;
                }
            }

            $this->newLine();
            $this->info("Sync completed!");
            $this->info("Successfully synced: {$synced} VMs");
            
            if ($errors > 0) {
                $this->warn("Errors: {$errors}");
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Sync failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Test Proxmox API connection
     */
    protected function testConnection()
    {
        $this->info('Testing Proxmox API connection...');
        
        $result = $this->proxmoxApi->testConnection();
        
        if ($result['success']) {
            $this->info('✓ ' . $result['message']);
            $this->info('Found ' . $result['nodes_count'] . ' node(s)');
            
            if (!empty($result['nodes'])) {
                $this->table(
                    ['Node', 'Status', 'CPU', 'Memory'],
                    collect($result['nodes'])->map(function ($node) {
                        return [
                            $node['node'],
                            $node['status'] ?? 'unknown',
                            isset($node['cpu']) ? round($node['cpu'] * 100, 2) . '%' : 'N/A',
                            isset($node['mem'], $node['maxmem']) 
                                ? round(($node['mem'] / $node['maxmem']) * 100, 2) . '%' 
                                : 'N/A'
                        ];
                    })
                );
            }
            
            return Command::SUCCESS;
        } else {
            $this->error('✗ ' . $result['message']);
            return Command::FAILURE;
        }
    }
}
