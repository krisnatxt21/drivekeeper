<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Dokumen</h2>
        <a href="{{ route('documents.create') }}" class="btn-primary">+ Upload Dokumen</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    @if($documents->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada dokumen.</p>
            <a href="{{ route('documents.create') }}" class="btn-primary inline-block mt-4">Upload Sekarang</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($documents as $document)
                <div class="card">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center text-primary text-xl">
                            📄
                        </div>
                        @if($document->expired_at)
                            @if($document->expired_at->isPast())
                                <span class="text-xs bg-red-500/20 text-red-400 px-2 py-1 rounded-full">Kadaluarsa</span>
                            @elseif($document->expired_at->diffInDays(now()) <= 30)
                                <span class="text-xs bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-full">Segera Expired</span>
                            @else
                                <span class="text-xs bg-green-500/20 text-green-400 px-2 py-1 rounded-full">Aktif</span>
                            @endif
                        @endif
                    </div>

                    <h3 class="font-bold text-white">{{ $document->title }}</h3>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $document->vehicle->brand }} {{ $document->vehicle->model }}
                    </p>

                    @if($document->expired_at)
                        <p class="text-xs text-gray-400 mt-1">
                            Exp: {{ $document->expired_at->format('d M Y') }}
                        </p>
                    @endif

                    <div class="flex gap-2 mt-4">
                        <a href="{{ asset('storage/' . $document->file_path) }}"
                           target="_blank" class="text-xs btn-secondary">Lihat</a>
                        <form action="{{ route('documents.destroy', $document) }}" method="POST"
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
