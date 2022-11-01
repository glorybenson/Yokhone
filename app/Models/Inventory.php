<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'immatriculation_number',
        'date_of_acquisition',
        'acquisition_cost',
        'millage_on_acquisition',
        'make',
        'model',
        'serie',
        'year'
    ];
}