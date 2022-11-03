<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'driver_id',
        'assigned_date',
        'revoked_date',
        'details_of_revokation'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }
}