<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('ai.index') }}" class="text-gray-400 hover:text-white">← Kembali</a>
        <h2 class="text-2xl font-bold text-white">🤖 Hasil Rekomendasi AI</h2>
    </div>

    {{-- Info Kendaraan --}}
    <div class="card mb-6">
        <p class="text-gray-400 text-sm">Kendaraan</p>
        <p class="text-xl font-bold text-white mt-1">
            {{ $vehicle->brand }} {{ $vehicle->model }} {{ $vehicle->year }}
        </p>
        <p class="text-gray-400 text-sm mt-1">
            {{ $vehicle->plate_number }} • Odometer: {{ number_format($vehicle->odometer) }} km
        </p>
    </div>

    {{-- Hasil Rekomendasi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="card text-center">
            <p class="text-gray-400 text-xs mb-2">Servis Berikutnya</p>
            <p class="text-2xl font-bold text-white">
                {{ number_format($result['recommendation']['next_service_km']) }} km
            </p>
            <p class="text-gray-500 text-xs mt-1">
                Sisa {{ number_format($result['recommendation']['km_remaining']) }} km
            </p>
        </div>

        <div class="card text-center">
            <p class="text-gray-400 text-xs mb-2">Estimasi Tanggal</p>
            <p class="text-2xl font-bold text-white">
                {{ \Carbon\Carbon::parse($result['recommendation']['next_service_date'])->format('d M Y') }}
            </p>
            <p class="text-gray-500 text-xs mt-1">
                {{ $result['recommendation']['next_service_days'] }} hari lagi
            </p>
        </div>

        <div class="card text-center">
            <p class="text-gray-400 text-xs mb-2">Estimasi Biaya</p>
            <p class="text-2xl font-bold text-white">
                {{ $result['recommendation']['estimated_cost_fmt'] }}
            </p>
            <p class="text-gray-500 text-xs mt-1">Perkiraan biaya servis</p>
        </div>

        <div class="card text-center">
            <p class="text-gray-400 text-xs mb-2">Status Urgensi</p>
            @php
                $urgency = $result['recommendation']['urgency'];
                $color = match($urgency) {
                    'segera' => 'text-red-400',
                    'normal' => 'text-yellow-400',
                    default  => 'text-green-400',
                };
            @endphp
            <p class="text-2xl font-bold {{ $color }}">
                {{ strtoupper($urgency) }}
            </p>
            <p class="text-gray-500 text-xs mt-1">
                @if($urgency === 'segera') Segera lakukan servis!
                @elseif($urgency === 'normal') Rencanakan servis segera
                @else Kendaraan dalam kondisi baik
                @endif
            </p>
        </div>

    </div>

    {{-- Servis Terakhir --}}
    <div class="card mb-6">
        <h3 class="font-bold text-white mb-3">📋 Servis Terakhir</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Tanggal</p>
                <p class="text-white">{{ $lastService->service_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-400">Jenis Servis</p>
                <p class="text-white">{{ $lastService->service_type }}</p>
            </div>
            <div>
                <p class="text-gray-400">Bengkel</p>
                <p class="text-white">{{ $lastService->workshop_name }}</p>
            </div>
            <div>
                <p class="text-gray-400">Odometer</p>
                <p class="text-white">{{ number_format($lastService->odometer) }} km</p>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex gap-3">
        <a href="{{ route('ai.index') }}" class="btn-secondary">
            🔄 Prediksi Ulang
        </a>
        <a href="{{ route('reminders.create') }}" class="btn-primary">
            🔔 Buat Pengingat Servis
        </a>
    </div>

</x-app-layout>
