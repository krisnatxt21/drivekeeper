<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('documents.index') }}" class="text-gray-400 hover:text-white">← Kembali</a>
        <h2 class="text-2xl font-bold text-white">Upload Dokumen</h2>
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

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
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

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Judul Dokumen *</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="STNK, BPKB, Asuransi, KIR..."
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">File Dokumen * (PDF/JPG/PNG, max 5MB)</label>
                    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:bg-primary file:text-white file:text-sm cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tanggal Kadaluarsa</label>
                    <input type="date" name="expired_at" value="{{ old('expired_at') }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Catatan</label>
                    <input type="text" name="notes" value="{{ old('notes') }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Upload</button>
                <a href="{{ route('documents.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>
