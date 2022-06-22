<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'start_date',
        'return_date',
        'reason',
        'total_number_of_days',
        'total_to_be_cut',
        'comment',
    ];
}
