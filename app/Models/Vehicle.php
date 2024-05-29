<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'fuel_type', 'fuel_capacity'
    ];

    public function loan_vehicle()
    {
        return $this->hasMany(VehicleLoan::class, 'vehicle_id', 'id');
    }
}
