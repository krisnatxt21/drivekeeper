<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = [
        'vehicle_id',
        'title',
        'reminder_date',
        'odometer_threshold',
        'notes',
        'is_done',
    ];

    // Cast otomatis tipe datanya
    protected $casts = [
        'reminder_date' => 'date',
        'is_done' => 'boolean',
    ];

    // Pengingat ini milik satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
