<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    protected $fillable = [
        'vehicle_id',
        'fueled_at',
        'liters',
        'price_per_liter',
        'total_cost',
        'odometer',
        'gas_station',
    ];

    // BBM ini milik satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
