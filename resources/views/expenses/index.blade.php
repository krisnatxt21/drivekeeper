<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Pengeluaran</h2>
        <a href="{{ route('expenses.create') }}" class="btn-primary">+ Tambah Pengeluaran</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    @if($expenses->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada catatan pengeluaran.</p>
            <a href="{{ route('expenses.create') }}" class="btn-primary inline-block mt-4">Tambah Sekarang</a>
        </div>
    @else
        <div class="card overflow-hidden p-0">
            <table class="w-full text-sm">
                <thead class="bg-surface-700 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Kendaraan</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Kategori</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-left">Jumlah</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-700">
                    @foreach($expenses as $expense)
                        <tr class="hover:bg-surface-700 transition-all">
                            <td class="px-6 py-4 text-white font-medium">
                                {{ $expense->vehicle->brand }} {{ $expense->vehicle->model }}
                                <span class="text-xs text-gray-400 block">{{ $expense->vehicle->plate_number }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $expense->expense_date->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-primary/20 text-primary text-xs px-2 py-1 rounded-full">
                                    {{ $expense->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-300">{{ $expense->description }}</td>
                            <td class="px-6 py-4 text-white font-medium">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-xs btn-secondary">Edit</a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
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
