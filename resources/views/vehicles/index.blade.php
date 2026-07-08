<x-app-layout>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Kendaraan Saya</h2>
        <a href="{{ route('vehicles.create') }}" class="btn-primary">
            + Tambah Kendaraan
        </a>
    </div>

    {{-- Flash message sukses --}}
    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- List Kendaraan --}}
    @if($vehicles->isEmpty())
        <div class="card text-center py-16">
            <p class="text-gray-400 text-lg">Belum ada kendaraan.</p>
            <a href="{{ route('vehicles.create') }}" class="btn-primary inline-block mt-4">
                Tambah Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vehicles as $vehicle)
                <div class="card hover:border-primary transition-all">

                    {{-- Header Card --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white text-xl">
                            🚗
                        </div>
                        <span class="text-xs bg-surface-700 text-gray-300 px-3 py-1 rounded-full">
                            {{ $vehicle->plate_number }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <h3 class="text-lg font-bold text-white">
                        {{ $vehicle->brand }} {{ $vehicle->model }}
                    </h3>
                    <p class="text-gray-400 text-sm mt-1">
                        {{ $vehicle->year }} • {{ $vehicle->color ?? '-' }}
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                        Odometer: {{ number_format($vehicle->odometer) }} km
                    </p>

                    {{-- Actions --}}
                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn-secondary text-xs">
                            Edit
                        </a>
                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus kendaraan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary text-xs text-red-400 hover:text-red-300">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
            </div>
        {{ $vehicles->links() }}
        </div>
    @endif

</x-app-layout>
