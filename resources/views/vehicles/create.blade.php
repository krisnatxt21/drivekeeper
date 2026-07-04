<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('vehicles.index') }}" class="text-gray-400 hover:text-white">
            ← Kembali
        </a>
        <h2 class="text-2xl font-bold text-white">Tambah Kendaraan</h2>
    </div>

    <div class="card max-w-2xl">

        {{-- Error validasi --}}
        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Merk *</label>
                    <input type="text" name="brand" value="{{ old('brand') }}"
                           placeholder="Toyota, Honda, Yamaha..."
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Model *</label>
                    <input type="text" name="model" value="{{ old('model') }}"
                           placeholder="Avanza, Beat, Vario..."
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tahun *</label>
                    <input type="number" name="year" value="{{ old('year') }}"
                           placeholder="2020"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Plat Nomor *</label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}"
                           placeholder="B 1234 XYZ"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Warna</label>
                    <input type="text" name="color" value="{{ old('color') }}"
                           placeholder="Hitam, Putih, Merah..."
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Odometer (km)</label>
                    <input type="number" name="odometer" value="{{ old('odometer', 0) }}"
                           placeholder="0"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nomor Mesin</label>
                    <input type="text" name="engine_number" value="{{ old('engine_number') }}"
                           placeholder="Opsional"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nomor Rangka</label>
                    <input type="text" name="chassis_number" value="{{ old('chassis_number') }}"
                           placeholder="Opsional"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Kendaraan</button>
                <a href="{{ route('vehicles.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>
