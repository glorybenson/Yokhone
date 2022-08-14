<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'employee_id',
        'hiring_date',
        'end_date',
        'CIN',
        'CIN_proof',
        'cell_1',
        'cell_2',
        'address',
        'contact_full_name',
        'contact_1_cell',
        'contact_1_cell2',
    ];
}
