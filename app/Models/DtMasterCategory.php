<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtMasterCategory extends Model
{
    protected $table    = 'dt_master_category';
    protected $fillable = ['name', 'slug', 'description'];

    // Relasi: satu kategori punya banyak produk
    public function products()
    {
        return $this->hasMany(DtMasterProduct::class, 'category_id');
    }
}
