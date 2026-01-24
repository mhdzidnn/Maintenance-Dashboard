@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div
                    class="w-12 h-12 rounded-xl {{ $vm->status == 'running' ? 'bg-green-500/10 text-green-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center border {{ $vm->status == 'running' ? 'border-green-500/20' : 'border-slate-200' }}">
                    <i data-lucide="{{ $vm->os_type == 'windows' ? 'monitor' : 'server' }}" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $vm->name }} ({{ $vm->id }})</h1>
                    <p class="text-slate-500">Node: {{ $vm->node }} &bull; Status: <span
                            class="{{ $vm->status == 'running' ? 'text-green-600' : 'text-slate-500' }} uppercase font-bold">{{ $vm->status }}</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('proxmox.datacenter', ['location' => $location]) }}"
                    class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                    Back to Datacenter
                </a>
                <button
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-blue-900/20">
                    Console
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status & Configuration -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="info" class="w-5 h-5 mr-2 text-blue-500"></i>
                    Status & Configuration
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Uptime</span>
                        <span class="text-slate-900 font-mono">{{ $vm->uptime }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">OS Type</span>
                        <span class="text-slate-900 capitalize flex items-center">
                            <i data-lucide="{{ $vm->os_type == 'windows' ? 'monitor' : 'terminal' }}"
                                class="w-4 h-4 mr-2 text-slate-400"></i>
                            {{ $vm->os_type }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">IP Address</span>
                        <span class="text-slate-900 font-mono">{{ $vm->ip_address }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-100">
                        <span class="text-slate-500">Boot Order</span>
                        <span class="text-slate-900">scsi0; ide2; net0</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-slate-500">HA State</span>
                        <span class="text-green-600">None</span>
                    </div>
                </div>
            </div>

            <!-- Resource Usage -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center">
                    <i data-lucide="activity" class="w-5 h-5 mr-2 text-purple-500"></i>
                    Resource Summary
                </h2>
                <div class="space-y-6">
                    <!-- CPU -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 text-sm">CPU Usage</span>
                            <span class="text-slate-800 text-sm font-bold">{{ $vm->cpu_usage }}% of {{ $vm->cpu_cores }}
                                CPU(s)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $vm->cpu_usage }}%"></div>
                        </div>
                    </div>

                    <!-- Memory -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 text-sm">Memory Usage</span>
                            <span class="text-slate-800 text-sm font-bold">{{ $vm->memory_usage_percent }}%
                                ({{ $vm->memory_usage_gb }}GiB of {{ $vm->memory_total_gb }}GiB)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-purple-500 h-2.5 rounded-full" style="width: {{ $vm->memory_usage_percent }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Disk -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-500 text-sm">Bootdisk Size</span>
                            <span class="text-slate-800 text-sm font-bold">{{ $vm->disk_total_gb }}GB</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            @php $diskPercent = ($vm->disk_usage_gb / $vm->disk_total_gb) * 100; @endphp
                            <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $diskPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Graphs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- CPU Usage Graph -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                    <i data-lucide="cpu" class="w-5 h-5 mr-2 text-blue-500"></i>
                    CPU Usage
                </h2>
                <div id="cpuChart" class="-ml-2"></div>
            </div>

            <!-- Memory Usage Graph -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                    <i data-lucide="memory-stick" class="w-5 h-5 mr-2 text-purple-500"></i>
                    Memory Usage
                </h2>
                <div id="memoryChart" class="-ml-2"></div>
            </div>

            <!-- Network Traffic Graph -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                    <i data-lucide="network" class="w-5 h-5 mr-2 text-emerald-500"></i>
                    Network Traffic (net0)
                </h2>
                <div id="networkChart" class="-ml-2"></div>
            </div>

            <!-- Disk IO Graph -->
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                    <i data-lucide="hard-drive" class="w-5 h-5 mr-2 text-amber-500"></i>
                    Disk IO
                </h2>
                <div id="diskChart" class="-ml-2"></div>
            </div>
        </div>
    </div>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Common Options for Area Charts
            const commonOptions = {
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    fontFamily: 'Inter, sans-serif',
                    background: 'transparent'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '10px',
                            fontFamily: 'Mono'
                        },
                        datetimeFormatter: {
                            year: 'yyyy',
                            month: 'MMM \'yy',
                            day: 'dd MMM',
                            hour: 'HH:mm'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '10px',
                            fontFamily: 'Mono'
                        },
                        formatter: (value) => value.toFixed(0)
                    }
                },
                grid: {
                    borderColor: 'rgba(255, 255, 255, 0.05)',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                },
                theme: {
                    mode: 'light'
                },
                tooltip: {
                    theme: 'dark',
                    x: {
                        format: 'yyyy/MM/dd HH:mm'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [50, 100, 100]
                    }
                }
            };

            // Generate Time Series Data
            const generateData = (count, min, max) => {
                let data = [];
                let now = new Date().getTime();
                for (let i = 0; i < count; i++) {
                    data.push([now - (count - i) * 60000, Math.floor(Math.random() * (max - min + 1)) + min]);
                }
                return data;
            };

            // CPU Chart
            new ApexCharts(document.querySelector("#cpuChart"), {
                ...commonOptions,
                colors: ['#3b82f6'], // Blue
                series: [{
                    name: 'CPU Usage',
                    data: generateData(30, 5, 60)
                }],
                yaxis: {
                    ...commonOptions.yaxis,
                    max: 100,
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: (v) => v + '%'
                    }
                },
            }).render();

            // Memory Chart
            new ApexCharts(document.querySelector("#memoryChart"), {
                ...commonOptions,
                colors: ['#eab308', '#3b82f6'], // Yellow (Total), Blue (Usage)
                series: [{
                        name: 'Total',
                        data: generateData(30, 16, 16)
                    }, // Flat 16GB
                    {
                        name: 'Usage',
                        data: generateData(30, 4, 12)
                    }
                ],
                yaxis: {
                    ...commonOptions.yaxis,
                    max: 18,
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: (v) => v + ' GB'
                    }
                },
            }).render();

            // Network Chart
            new ApexCharts(document.querySelector("#networkChart"), {
                ...commonOptions,
                colors: ['#eab308', '#3b82f6'], // Yellow (In), Blue (Out)
                series: [{
                        name: 'NetIn',
                        data: generateData(30, 10, 100)
                    },
                    {
                        name: 'NetOut',
                        data: generateData(30, 5, 50)
                    }
                ],
                yaxis: {
                    ...commonOptions.yaxis,
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: (v) => v + ' Mbps'
                    }
                },
            }).render();

            // Disk Chart
            new ApexCharts(document.querySelector("#diskChart"), {
                ...commonOptions,
                colors: ['#eab308', '#3b82f6'], // Yellow (Read), Blue (Write)
                series: [{
                        name: 'Read',
                        data: generateData(30, 1, 20)
                    },
                    {
                        name: 'Write',
                        data: generateData(30, 5, 50)
                    }
                ],
                yaxis: {
                    ...commonOptions.yaxis,
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: (v) => v + ' MB/s'
                    }
                },
            }).render();
        });
    </script>
@endsection
