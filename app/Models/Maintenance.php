<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'date_maintenance',
        'reason',
        'amount_paid',
        'diagnostics',
    ];
}
