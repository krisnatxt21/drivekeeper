<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('vehicle')->orderBy('reminder_date')->get();

        return view('reminders.index', compact('reminders'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('reminders.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'         => 'required|exists:vehicles,id',
            'title'              => 'required|string|max:100',
            'reminder_date'      => 'required|date',
            'odometer_threshold' => 'nullable|integer|min:0',
            'notes'              => 'nullable|string',
        ]);

        Reminder::create($request->only([
            'vehicle_id', 'title', 'reminder_date',
            'odometer_threshold', 'notes'
        ]));

        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat berhasil ditambahkan!');
    }

    public function edit(Reminder $reminder)
    {
        abort_if($reminder->vehicle->user_id !== auth()->id(), 403);
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('reminders.edit', compact('reminder', 'vehicles'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        abort_if($reminder->vehicle->user_id !== auth()->id(), 403);

        $request->validate([
            'vehicle_id'         => 'required|exists:vehicles,id',
            'title'              => 'required|string|max:100',
            'reminder_date'      => 'required|date',
            'odometer_threshold' => 'nullable|integer|min:0',
            'notes'              => 'nullable|string',
        ]);

        $reminder->update($request->only([
            'vehicle_id', 'title', 'reminder_date',
            'odometer_threshold', 'notes'
        ]));

        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat berhasil diupdate!');
    }

    // Toggle selesai/belum
    public function toggle(Reminder $reminder)
    {
        abort_if($reminder->vehicle->user_id !== auth()->id(), 403);
        $reminder->update(['is_done' => !$reminder->is_done]);
        return back()->with('success', 'Status pengingat diupdate!');
    }

    public function destroy(Reminder $reminder)
    {
        abort_if($reminder->vehicle->user_id !== auth()->id(), 403);
        $reminder->delete();
        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat berhasil dihapus!');
    }
}
