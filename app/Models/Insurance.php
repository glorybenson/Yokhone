<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'company_name',
        'date_started',
        'reason',
        'company_contact_name',
        'company_contact_tel_no',
        'date_ending',
        'company_email',
        'other_details',
    ];
}
