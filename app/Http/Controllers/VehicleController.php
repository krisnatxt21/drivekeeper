<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);
        return view('vehicles.index', compact('vehicles'));
    }

    // Tampilkan form tambah kendaraan
    public function create()
    {
        return view('vehicles.create');
    }

    // Simpan kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'brand'        => 'required|string|max:100',
            'model'        => 'required|string|max:100',
            'year'         => 'required|integer|min:1900|max:2100',
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'color'        => 'nullable|string|max:50',
            'engine_number'  => 'nullable|string|max:100',
            'chassis_number' => 'nullable|string|max:100',
            'odometer'     => 'nullable|integer|min:0',
        ]);

        Vehicle::create([
            'user_id'        => auth()->id(),
            'brand'          => $request->brand,
            'model'          => $request->model,
            'year'           => $request->year,
            'plate_number'   => $request->plate_number,
            'color'          => $request->color,
            'engine_number'  => $request->engine_number,
            'chassis_number' => $request->chassis_number,
            'odometer'       => $request->odometer ?? 0,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    // Tampilkan detail kendaraan
    public function show(Vehicle $vehicle)
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($vehicle->user_id !== auth()->id(), 403);
        return view('vehicles.show', compact('vehicle'));
    }

    // Tampilkan form edit
    public function edit(Vehicle $vehicle)
    {
        abort_if($vehicle->user_id !== auth()->id(), 403);
        return view('vehicles.edit', compact('vehicle'));
    }

    // Update kendaraan
    public function update(Request $request, Vehicle $vehicle)
    {
        abort_if($vehicle->user_id !== auth()->id(), 403);

        $request->validate([
            'brand'        => 'required|string|max:100',
            'model'        => 'required|string|max:100',
            'year'         => 'required|integer|min:1900|max:2100',
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'color'        => 'nullable|string|max:50',
            'engine_number'  => 'nullable|string|max:100',
            'chassis_number' => 'nullable|string|max:100',
            'odometer'     => 'nullable|integer|min:0',
        ]);

        $vehicle->update($request->except(['_token', '_method']));

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil diupdate!');
    }

    // Hapus kendaraan
    public function destroy(Vehicle $vehicle)
    {
        abort_if($vehicle->user_id !== auth()->id(), 403);
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dihapus!');
    }
}
