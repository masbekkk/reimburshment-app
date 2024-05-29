<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLoan extends Model
{
    use HasFactory;
    protected $table = 'vehicle_loan';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function stakeholder()
    {
        return $this->belongsTo(User::class, 'stakeholder_id', 'id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id','id');
    }
}
