<div class="glass-card p-6 h-full flex flex-col group/card relative overflow-hidden" x-data="{
    initChart() {
        const ctx = document.getElementById('usageChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @js($labels),
                datasets: [{
                    label: 'Storage Usage %',
                    data: @js($usageData),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    fill: true,
                    tension: 0.5,
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointHoverRadius: 6,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#020617',
                        titleFont: { family: 'Inter', size: 10, weight: 'bold' },
                        bodyFont: { family: 'Inter', size: 10 },
                        padding: 12,
                        displayColors: false,
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: { display: false },
                    y: {
                        display: false,
                        min: 60,
                        max: 85
                    }
                }
            }
        });
    }
}"
    x-init="initChart()">

    <div class="flex items-center justify-between mb-6 relative z-10">
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">USAGE TREND</h3>
        <div class="flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">+2.4% HEURISTIC</span>
        </div>
    </div>

    <div class="flex-1 relative z-10 min-h-[140px]">
        <canvas id="usageChart"></canvas>
    </div>

    <div
        class="mt-6 flex items-center justify-between text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] relative z-10">
        <span class="flex items-center"><i data-lucide="calendar" class="w-3 h-3 mr-2"></i>PREVIOUS CYCLE</span>
        <span class="flex items-center">CURRENT TIMESTAMP<i data-lucide="clock-3" class="w-3 h-3 ml-2"></i></span>
    </div>
</div>
