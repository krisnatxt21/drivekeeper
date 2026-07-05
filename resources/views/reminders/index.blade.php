<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Pengingat</h2>
        <a href="{{ route('reminders.create') }}" class="btn-primary">+ Tambah Pengingat</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    @if($reminders->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada pengingat.</p>
            <a href="{{ route('reminders.create') }}" class="btn-primary inline-block mt-4">Tambah Sekarang</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($reminders as $reminder)
                <div class="card {{ $reminder->is_done ? 'opacity-60' : '' }}">

                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-bold text-white {{ $reminder->is_done ? 'line-through' : '' }}">
                                {{ $reminder->title }}
                            </h3>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $reminder->vehicle->brand }} {{ $reminder->vehicle->model }}
                            </p>
                        </div>
                        @if($reminder->is_done)
                            <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">Selesai</span>
                        @else
                            <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">Aktif</span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-400 mb-1">
                        📅 {{ $reminder->reminder_date->format('d M Y') }}
                    </p>
                    @if($reminder->odometer_threshold)
                        <p class="text-sm text-gray-400 mb-3">
                            🔢 {{ number_format($reminder->odometer_threshold) }} km
                        </p>
                    @endif

                    <div class="flex gap-2 mt-4">
                        <form action="{{ route('reminders.toggle', $reminder) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs btn-secondary">
                                {{ $reminder->is_done ? 'Batalkan' : '✓ Selesai' }}
                            </button>
                        </form>
                        <a href="{{ route('reminders.edit', $reminder) }}" class="text-xs btn-secondary">Edit</a>
                        <form action="{{ route('reminders.destroy', $reminder) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs btn-secondary text-red-400">Hapus</button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</x-app-layout>
