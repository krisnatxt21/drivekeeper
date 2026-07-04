<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Riwayat Servis</h2>
        <a href="{{ route('service-records.create') }}" class="btn-primary">
            + Tambah Servis
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($serviceRecords->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada riwayat servis.</p>
            <a href="{{ route('service-records.create') }}" class="btn-primary inline-block mt-4">
                Tambah Sekarang
            </a>
        </div>
    @else
        <div class="card overflow-hidden p-0">
            <table class="w-full text-sm">
                <thead class="bg-surface-700 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Kendaraan</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Bengkel</th>
                        <th class="px-6 py-3 text-left">Jenis Servis</th>
                        <th class="px-6 py-3 text-left">Odometer</th>
                        <th class="px-6 py-3 text-left">Biaya</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-700">
                    @foreach($serviceRecords as $record)
                        <tr class="hover:bg-surface-700 transition-all">
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $record->vehicle->brand }} {{ $record->vehicle->model }}
                                <span class="text-xs text-gray-400 block">{{ $record->vehicle->plate_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $record->service_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $record->workshop_name }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-primary/20 text-primary text-xs px-2 py-1 rounded-full">
                                    {{ $record->service_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ number_format($record->odometer) }} km</td>
                            <td class="px-6 py-4 text-white font-medium">
                                Rp {{ number_format($record->cost, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('service-records.edit', $record) }}"
                                       class="text-xs btn-secondary">Edit</a>
                                    <form action="{{ route('service-records.destroy', $record) }}" method="POST"
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
