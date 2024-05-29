<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    public function loan_vehicle()
    {
        return $this->hasMany(VehicleLoan::class, 'vehicle_id', 'id');
    }
}
