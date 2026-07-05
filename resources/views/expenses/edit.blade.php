<x-app-layout>

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('expenses.index') }}" class="text-gray-400 hover:text-white">← Kembali</a>
        <h2 class="text-2xl font-bold text-white">Edit Pengeluaran</h2>
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

        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Kendaraan *</label>
                    <select name="vehicle_id"
                            class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}"
                                {{ old('vehicle_id', $expense->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->plate_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Tanggal *</label>
                    <input type="date" name="expense_date"
                           value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Kategori *</label>
                    <select name="category"
                            class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                        @foreach(['Servis', 'Ban', 'Oli', 'Modifikasi', 'Pajak', 'Lainnya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $expense->category) == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Deskripsi *</label>
                    <input type="text" name="description"
                           value="{{ old('description', $expense->description) }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Jumlah (Rp) *</label>
                    <input type="number" name="amount"
                           value="{{ old('amount', $expense->amount) }}"
                           class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Catatan</label>
                    <textarea name="notes" rows="3"
                              class="w-full bg-surface-700 border border-surface-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-primary">{{ old('notes', $expense->notes) }}</textarea>
                </div>

            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Update</button>
                <a href="{{ route('expenses.index') }}" class="btn-secondary">Batal</a>
            </div>

        </form>
    </div>

</x-app-layout>
