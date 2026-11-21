<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtProductPreprocessing extends Model
{
    protected $table      = 'dt_product_preprocessing';
    protected $fillable   = ['product_id', 'cleaned_text', 'tokens', 'processed_at'];
    public    $timestamps = false;

    public function product()
    {
        return $this->belongsTo(DtMasterProduct::class, 'product_id');
    }
}
