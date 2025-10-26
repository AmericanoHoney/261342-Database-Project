<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPromotion extends Model
{
    use HasFactory;

    protected $table = 'order_promotions';
    public $timestamps = true;
    protected $fillable = ['order_id', 'promotion_id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
