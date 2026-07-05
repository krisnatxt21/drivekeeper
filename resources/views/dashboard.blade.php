<x-app-layout>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="card">
            <p class="text-gray-400 text-sm">Total Kendaraan</p>
            <p class="text-3xl font-bold text-white mt-1">{{ $totalVehicles }}</p>
            <a href="{{ route('vehicles.index') }}" class="text-primary text-xs mt-2 block">Lihat semua →</a>
        </div>

        <div class="card">
            <p class="text-gray-400 text-sm">Pengeluaran Bulan Ini</p>
            <p class="text-3xl font-bold text-white mt-1">Rp {{ number_format($totalExpensesThisMonth, 0, ',', '.') }}</p>
            <a href="{{ route('expenses.index') }}" class="text-primary text-xs mt-2 block">Lihat semua →</a>
        </div>

        <div class="card">
            <p class="text-gray-400 text-sm">Total Pengeluaran</p>
            <p class="text-3xl font-bold text-white mt-1">Rp {{ number_format($totalExpensesAll, 0, ',', '.') }}</p>
            <p class="text-gray-500 text-xs mt-2">Semua waktu</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Pengingat Aktif --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-white">🔔 Pengingat Terdekat</h3>
                <a href="{{ route('reminders.index') }}" class="text-primary text-xs">Lihat semua →</a>
            </div>
            @if($upcomingReminders->isEmpty())
                <p class="text-gray-400 text-sm">Tidak ada pengingat aktif.</p>
            @else
                <div class="space-y-3">
                    @foreach($upcomingReminders as $reminder)
                        <div class="flex items-center justify-between py-2 border-b border-surface-700">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $reminder->title }}</p>
                                <p class="text-gray-400 text-xs">{{ $reminder->vehicle->brand }} {{ $reminder->vehicle->model }}</p>
                            </div>
                            <span class="text-yellow-400 text-xs">{{ $reminder->reminder_date->format('d M Y') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Servis Terakhir --}}
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-white">🔧 Servis Terakhir</h3>
                <a href="{{ route('service-records.index') }}" class="text-primary text-xs">Lihat semua →</a>
            </div>
            @if($recentServices->isEmpty())
                <p class="text-gray-400 text-sm">Belum ada riwayat servis.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentServices as $service)
                        <div class="flex items-center justify-between py-2 border-b border-surface-700">
                            <div>
                                <p class="text-white text-sm font-medium">{{ $service->service_type }}</p>
                                <p class="text-gray-400 text-xs">{{ $service->vehicle->brand }} {{ $service->vehicle->model }} • {{ $service->workshop_name }}</p>
                            </div>
                            <span class="text-gray-400 text-xs">{{ $service->service_date->format('d M Y') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Grafik Pengeluaran --}}
    <div class="card">
        <h3 class="font-bold text-white mb-4">📊 Grafik Pengeluaran 6 Bulan Terakhir</h3>
        <canvas id="expenseChart" height="80"></canvas>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($expenseChart->pluck('month'));
        const data = @json($expenseChart->pluck('total'));

        new Chart(document.getElementById('expenseChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengeluaran (Rp)',
                    data: data,
                    backgroundColor: '#e63946',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#9ca3af' } } },
                scales: {
                    x: { ticks: { color: '#9ca3af' }, grid: { color: '#2a2a2a' } },
                    y: { ticks: { color: '#9ca3af' }, grid: { color: '#2a2a2a' } }
                }
            }
        });
    </script>

</x-app-layout>
