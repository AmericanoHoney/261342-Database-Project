<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = ['customer_id', 'order_date', 'total_price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'order_promotions', 'order_id', 'promotion_id');
    }
}
