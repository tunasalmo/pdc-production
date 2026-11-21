<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtProductNormalization extends Model
{
    protected $table      = 'dt_product_normalization';
    protected $fillable   = ['product_id', 'tfidf_vector', 'terms', 'normalized_at'];
    public    $timestamps = false;

    public function product()
    {
        return $this->belongsTo(DtMasterProduct::class, 'product_id');
    }
}
