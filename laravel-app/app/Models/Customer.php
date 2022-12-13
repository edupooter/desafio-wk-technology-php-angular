<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'name',
        'cpf',
        'date_of_birth',
        'email',
        'ad_cep',
        'ad_street',
        'ad_number',
        'ad_comp',
        'ad_city',
    ];
}
