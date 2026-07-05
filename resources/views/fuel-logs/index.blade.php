<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Catatan BBM</h2>
        <a href="{{ route('fuel-logs.create') }}" class="btn-primary">+ Tambah BBM</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    @if($fuelLogs->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada catatan BBM.</p>
            <a href="{{ route('fuel-logs.create') }}" class="btn-primary inline-block mt-4">Tambah Sekarang</a>
        </div>
    @else
        <div class="card overflow-hidden p-0">
            <table class="w-full text-sm">
                <thead class="bg-surface-700 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Kendaraan</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Liter</th>
                        <th class="px-6 py-3 text-left">Harga/Liter</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Odometer</th>
                        <th class="px-6 py-3 text-left">SPBU</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-700">
                    @foreach($fuelLogs as $log)
                        <tr class="hover:bg-surface-700 transition-all">
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $log->vehicle->brand }} {{ $log->vehicle->model }}
                                <span class="text-xs text-gray-400 block">{{ $log->vehicle->plate_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $log->fueled_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $log->liters }} L</td>
                            <td class="px-6 py-4 text-gray-300">Rp {{ number_format($log->price_per_liter, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-white font-medium">Rp {{ number_format($log->total_cost, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ number_format($log->odometer) }} km</td>
                            <td class="px-6 py-4 text-gray-300">{{ $log->gas_station ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('fuel-logs.edit', $log) }}" class="text-xs btn-secondary">Edit</a>
                                    <form action="{{ route('fuel-logs.destroy', $log) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs btn-secondary text-red-400">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</x-app-layout>
