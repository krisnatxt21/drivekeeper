<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'vehicle_id',
        'expense_date',
        'category',
        'description',
        'amount',
        'notes',
    ];

    // Pengeluaran ini milik satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
