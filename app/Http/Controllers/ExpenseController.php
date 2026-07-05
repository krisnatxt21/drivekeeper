<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::whereHas('vehicle', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('vehicle')->latest()->get();

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('expenses.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'expense_date' => 'required|date',
            'category'     => 'required|string',
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'notes'        => 'nullable|string',
        ]);

        Expense::create($request->only([
            'vehicle_id', 'expense_date', 'category',
            'description', 'amount', 'notes'
        ]));

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        abort_if($expense->vehicle->user_id !== auth()->id(), 403);
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('expenses.edit', compact('expense', 'vehicles'));
    }

    public function update(Request $request, Expense $expense)
    {
        abort_if($expense->vehicle->user_id !== auth()->id(), 403);

        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'expense_date' => 'required|date',
            'category'     => 'required|string',
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'notes'        => 'nullable|string',
        ]);

        $expense->update($request->only([
            'vehicle_id', 'expense_date', 'category',
            'description', 'amount', 'notes'
        ]));

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diupdate!');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->vehicle->user_id !== auth()->id(), 403);
        $expense->delete();
        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
