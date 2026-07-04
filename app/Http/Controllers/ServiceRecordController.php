<?php

namespace App\Http\Controllers;

use App\Models\ServiceRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    // Tampilkan semua riwayat servis milik user
    public function index()
    {
        $serviceRecords = ServiceRecord::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('vehicle')->latest()->get();

        return view('service-records.index', compact('serviceRecords'));
    }

    // Form tambah servis
    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('service-records.create', compact('vehicles'));
    }

    // Simpan servis baru
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'service_date'  => 'required|date',
            'workshop_name' => 'required|string|max:100',
            'service_type'  => 'required|string|max:100',
            'odometer'      => 'required|integer|min:0',
            'cost'          => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        ServiceRecord::create($request->only([
            'vehicle_id', 'service_date', 'workshop_name',
            'service_type', 'odometer', 'cost', 'notes'
        ]));

        return redirect()->route('service-records.index')
            ->with('success', 'Riwayat servis berhasil ditambahkan!');
    }

    // Form edit servis
    public function edit(ServiceRecord $serviceRecord)
    {
        abort_if($serviceRecord->vehicle->user_id !== auth()->id(), 403);
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('service-records.edit', compact('serviceRecord', 'vehicles'));
    }

    // Update servis
    public function update(Request $request, ServiceRecord $serviceRecord)
    {
        abort_if($serviceRecord->vehicle->user_id !== auth()->id(), 403);

        $request->validate([
            'vehicle_id'    => 'required|exists:vehicles,id',
            'service_date'  => 'required|date',
            'workshop_name' => 'required|string|max:100',
            'service_type'  => 'required|string|max:100',
            'odometer'      => 'required|integer|min:0',
            'cost'          => 'required|numeric|min:0',
            'notes'         => 'nullable|string',
        ]);

        $serviceRecord->update($request->only([
            'vehicle_id', 'service_date', 'workshop_name',
            'service_type', 'odometer', 'cost', 'notes'
        ]));

        return redirect()->route('service-records.index')
            ->with('success', 'Riwayat servis berhasil diupdate!');
    }

    // Hapus servis
    public function destroy(ServiceRecord $serviceRecord)
    {
        abort_if($serviceRecord->vehicle->user_id !== auth()->id(), 403);
        $serviceRecord->delete();
        return redirect()->route('service-records.index')
            ->with('success', 'Riwayat servis berhasil dihapus!');
    }
}
