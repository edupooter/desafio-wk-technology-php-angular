<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellingOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    private $products = [];
    private float $total = 0;

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

    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        $this->sumUp($product);
    }

    private function sumUp(Product $product)
    {
        $this->total += $product->amount;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
