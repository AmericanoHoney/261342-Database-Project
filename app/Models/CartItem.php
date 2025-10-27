<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function subtotal()
    {
        return $this->quantity * ($this->product->price ?? 0);
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('cart_id', $this->cart_id)
                     ->where('product_id', $this->product_id);
    }
}
