<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\ServiceRecord;
use App\Models\Expense;
use App\Models\Reminder;
use App\Models\FuelLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Total kendaraan
        $totalVehicles = Vehicle::where('user_id', $userId)->count();

        // Total pengeluaran bulan ini
        $totalExpensesThisMonth = Expense::whereHas('vehicle', fn($q) => $q->where('user_id', $userId))
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');

        // Total pengeluaran keseluruhan
        $totalExpensesAll = Expense::whereHas('vehicle', fn($q) => $q->where('user_id', $userId))
            ->sum('amount');

        // Pengingat aktif terdekat
        $upcomingReminders = Reminder::whereHas('vehicle', fn($q) => $q->where('user_id', $userId))
            ->where('is_done', false)
            ->where('reminder_date', '>=', now())
            ->orderBy('reminder_date')
            ->take(3)
            ->with('vehicle')
            ->get();

        // Servis terakhir
        $recentServices = ServiceRecord::whereHas('vehicle', fn($q) => $q->where('user_id', $userId))
            ->with('vehicle')
            ->latest('service_date')
            ->take(5)
            ->get();

        // Kendaraan milik user
        $vehicles = Vehicle::where('user_id', $userId)->get();

        // Data grafik pengeluaran 6 bulan terakhir
        $expenseChart = Expense::whereHas('vehicle', fn($q) => $q->where('user_id', $userId))
            ->where('expense_date', '>=', now()->subMonths(6))
            ->selectRaw("TO_CHAR(expense_date, 'Mon') as month, SUM(amount) as total")
            ->groupByRaw("TO_CHAR(expense_date, 'Mon'), DATE_TRUNC('month', expense_date)")
            ->orderByRaw("DATE_TRUNC('month', expense_date)")
            ->get();

        return view('dashboard', compact(
            'totalVehicles',
            'totalExpensesThisMonth',
            'totalExpensesAll',
            'upcomingReminders',
            'recentServices',
            'vehicles',
            'expenseChart'
        ));
    }
}
