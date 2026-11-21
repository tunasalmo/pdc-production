<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DtMasterProduct extends Model
{
    protected $table    = 'dt_master_product';
    protected $fillable = [
        'uid', 'category_id', 'name', 'description',
        'material', 'image_url', 'price',
    ];

    // Auto-generate uid saat produk baru dibuat
    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->uid = (string) Str::uuid();
        });
    }

    // Gunakan uid sebagai route key (bukan id)
    public function getRouteKeyName(): string
    {
        return 'uid';
    }

    public function category()
    {
        return $this->belongsTo(DtMasterCategory::class, 'category_id');
    }

    public function preprocessing()
    {
        return $this->hasOne(DtProductPreprocessing::class, 'product_id');
    }

    public function normalization()
    {
        return $this->hasOne(DtProductNormalization::class, 'product_id');
    }
}