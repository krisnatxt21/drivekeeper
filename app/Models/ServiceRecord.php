<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'service_date',
        'workshop_name',
        'service_type',
        'odometer',
        'cost',
        'notes',
        'receipt_photo',
    ];

    // Servis ini milik satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
