<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-white">🤖 AI Rekomendasi Servis</h2>
    </div>

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500 text-red-400 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Form --}}
        <div class="card">
            <h3 class="font-bold text-white mb-4">Masukkan Data Kendaraan</h3>

            <form action="{{ route('ai.predict') }}" method="POST">
                @csrf

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Pilih Kendaraan *</label>
                        <select name="vehicle_id"
                                class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">
                                    {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Tipe Kendaraan *</label>
                        <select name="vehicle_type"
                                class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            <option value="mobil">Mobil</option>
                            <option value="motor">Motor</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Jenis Oli *</label>
                        <select name="oil_type"
                                class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            <option value="mineral">Mineral</option>
                            <option value="semi-synthetic">Semi Synthetic</option>
                            <option value="full-synthetic">Full Synthetic</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Kondisi Jalan *</label>
                        <select name="road_condition"
                                class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            <option value="sangat buruk">Sangat Buruk</option>
                            <option value="buruk">Buruk</option>
                            <option value="normal" selected>Normal</option>
                            <option value="baik">Baik</option>
                            <option value="sangat baik">Sangat Baik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Tipe Penggunaan *</label>
                        <select name="usage_type"
                                class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            <option value="harian_kota">Harian Kota</option>
                            <option value="harian_luar_kota">Harian Luar Kota</option>
                            <option value="campuran" selected>Campuran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Rata-rata KM per Hari *</label>
                        <input type="number" name="avg_km_per_day" value="30" min="1"
                               class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                    </div>

                </div>

                <button type="submit" class="btn-primary w-full mt-6">
                    🔮 Dapatkan Rekomendasi AI
                </button>

            </form>
        </div>

        {{-- Info --}}
        <div class="card">
            <h3 class="font-bold text-white mb-4">ℹ️ Tentang Fitur AI Ini</h3>
            <div class="space-y-3 text-sm text-gray-400">
                <p>AI DriveKeeper menggunakan model <strong class="text-white">Gradient Boosting Regressor</strong> yang dilatih dengan data standar perawatan pabrikan.</p>
                <p>Model ini mampu memprediksi:</p>
                <ul class="list-disc list-inside space-y-1 ml-2">
                    <li>Estimasi km servis berikutnya</li>
                    <li>Estimasi tanggal servis</li>
                    <li>Estimasi biaya servis</li>
                    <li>Tingkat urgensi servis</li>
                </ul>
                <p class="mt-4">Faktor yang dipertimbangkan:</p>
                <ul class="list-disc list-inside space-y-1 ml-2">base → Connection String → URI
                    <li>Kondisi jalan</li>
                    <li>Jenis oli yang digunakan</li>
                    <li>Pola penggunaan kendaraan</li>
                    <li>Usia kendaraan</li>
                    <li>Riwayat servis sebelumnya</li>
                </ul>
                <p class="text-xs text-gray-500 mt-4">* Akurasi model: R² = 0.9980 (Next Service KM)</p>
            </div>
        </div>

    </div>

</x-app-layout>
