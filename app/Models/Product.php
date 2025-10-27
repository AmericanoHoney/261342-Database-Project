<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name', 'price', 'stock', 'description', 'image_url', 'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'product_id');
    }

    /** คืน URL รูปภาพที่พร้อมใช้บนหน้าเว็บ */
    public function getImageUrlAttribute($value)
    {
        $v = trim((string) $value);

        // ถ้าเป็น URL เต็มอยู่แล้ว ก็ส่งคืนไปเลย
        if (Str::startsWith($v, ['http://', 'https://', '//'])) {
            return $v;
        }

        // ถ้าไม่ได้ใส่อะไร ใช้ placeholder
        if ($v === '') {
            return asset('images/placeholder.jpg');
        }

        // รองรับทั้งกรณีผู้ใช้เก็บเป็นไฟล์เนม หรือซับพาธ
        // baseDir คือโฟลเดอร์เก็บรูปสินค้า
        $baseDir = 'images/products';

        // ตัดสแลชหน้าหลังออกก่อนต่อพาธ
        $v = ltrim($v, '/');

        // ถ้า v เริ่มด้วย 'images/products' แล้ว ก็ไม่ต้องเติม baseDir ซ้ำ
        if (Str::startsWith($v, $baseDir)) {
            return asset($v);
        }

        return asset($baseDir . '/' . $v);
    }
}
