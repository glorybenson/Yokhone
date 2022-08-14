<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_name',
        'full_address',
        'contact_full_name',
        'contact_phone',
        'contact_email',
        'date_become_client',
        'referred_by',
        'employee_id',
        'note',
    ];
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
