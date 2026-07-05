<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('fuel-logs.index') }}" class="text-gray-400 hover:text-white">← Kembali</a>
        <h2 class="text-2xl font-bold text-white">Tambah Catatan BBM</h2>
    </div>

    <div class="card max-w-2xl">

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fuel-logs.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Kendaraan *</label>
                    <select name="vehicle_id"
                            class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->plate_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tanggal *</label>
                    <input type="date" name="fueled_at" value="{{ old('fueled_at') }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nama SPBU</label>
                    <input type="text" name="gas_station" value="{{ old('gas_station') }}"
                           placeholder="Pertamina, Shell..."
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Jumlah Liter *</label>
                    <input type="number" name="liters" value="{{ old('liters') }}"
                           placeholder="20.5" step="0.01"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Harga per Liter (Rp) *</label>
                    <input type="number" name="price_per_liter" value="{{ old('price_per_liter') }}"
                           placeholder="10000"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Odometer (km) *</label>
                    <input type="number" name="odometer" value="{{ old('odometer') }}"
                           placeholder="50000"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('fuel-logs.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>
