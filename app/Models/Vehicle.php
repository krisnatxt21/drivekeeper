<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'plate_number',
        'color',
        'engine_number',
        'chassis_number',
        'odometer',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
