<?php

// app/Models/Promotion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $primaryKey = 'promotion_id';

    // เก็บ path (เช่น "images/promotions/sale30.jpg") หรือแค่ไฟล์เนมก็ได้
    protected $fillable = ['name', 'promotion_photo', 'discount_percent', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'discount_percent' => 'float',
    ];

    // ใช้ใน Blade: $promotion->photo_url
    public function getPhotoUrlAttribute(): string
    {
        $p = trim((string) $this->promotion_photo);

        // ถ้าใส่มาเป็น URL เต็มอยู่แล้ว
        if (preg_match('~^https?://~', $p)) return $p;

        // ถ้าเก็บแค่ไฟล์เนม → ต่อโฟลเดอร์ให้
        if ($p !== '' && !str_starts_with($p, 'images/')) {
            $p = "images/promotions/{$p}";
        }

        // สุดท้ายใช้ asset() เสมอ (เสิร์ฟจาก public/)
        return asset($p ?: 'images/promotion-placeholder.jpg');
    }
}

