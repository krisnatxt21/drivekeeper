<?php

namespace App\Http\Controllers;

use App\Models\FuelLog;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FuelLogController extends Controller
{
    public function index()
    {
        $fuelLogs = FuelLog::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('vehicle')->latest()->get();

        return view('fuel-logs.index', compact('fuelLogs'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('fuel-logs.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'fueled_at'       => 'required|date',
            'liters'          => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'odometer'        => 'required|integer|min:0',
            'gas_station'     => 'nullable|string|max:100',
        ]);

        // Hitung total_cost otomatis
        $totalCost = $request->liters * $request->price_per_liter;

        FuelLog::create([
            'vehicle_id'      => $request->vehicle_id,
            'fueled_at'       => $request->fueled_at,
            'liters'          => $request->liters,
            'price_per_liter' => $request->price_per_liter,
            'total_cost'      => $totalCost,
            'odometer'        => $request->odometer,
            'gas_station'     => $request->gas_station,
        ]);

        return redirect()->route('fuel-logs.index')
            ->with('success', 'Catatan BBM berhasil ditambahkan!');
    }

    public function edit(FuelLog $fuelLog)
    {
        abort_if($fuelLog->vehicle->user_id !== auth()->id(), 403);
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('fuel-logs.edit', compact('fuelLog', 'vehicles'));
    }

    public function update(Request $request, FuelLog $fuelLog)
    {
        abort_if($fuelLog->vehicle->user_id !== auth()->id(), 403);

        $request->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'fueled_at'       => 'required|date',
            'liters'          => 'required|numeric|min:0',
            'price_per_liter' => 'required|numeric|min:0',
            'odometer'        => 'required|integer|min:0',
            'gas_station'     => 'nullable|string|max:100',
        ]);

        $fuelLog->update([
            'vehicle_id'      => $request->vehicle_id,
            'fueled_at'       => $request->fueled_at,
            'liters'          => $request->liters,
            'price_per_liter' => $request->price_per_liter,
            'total_cost'      => $request->liters * $request->price_per_liter,
            'odometer'        => $request->odometer,
            'gas_station'     => $request->gas_station,
        ]);

        return redirect()->route('fuel-logs.index')
            ->with('success', 'Catatan BBM berhasil diupdate!');
    }

    public function destroy(FuelLog $fuelLog)
    {
        abort_if($fuelLog->vehicle->user_id !== auth()->id(), 403);
        $fuelLog->delete();
        return redirect()->route('fuel-logs.index')
            ->with('success', 'Catatan BBM berhasil dihapus!');
    }
}
