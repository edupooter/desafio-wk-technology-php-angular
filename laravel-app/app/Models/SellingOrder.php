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
        'product_id',
        'customer_id',
        'total',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
