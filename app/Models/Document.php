<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'vehicle_id',
        'title',
        'file_path',
        'expired_at',
        'notes',
    ];

    protected $casts = [
        'expired_at' => 'date',
    ];

    // Dokumen ini milik satu kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
