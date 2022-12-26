<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellingOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'sold_at',
        'customer_id',
        'total',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
