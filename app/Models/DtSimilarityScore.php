<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtSimilarityScore extends Model
{
    protected $table      = 'dt_similarity_score';
    protected $fillable   = ['product_a_id', 'product_b_id', 'cosine_score', 'computed_at'];
    public    $timestamps = false;

    public function productA()
    {
        return $this->belongsTo(DtMasterProduct::class, 'product_a_id');
    }

    public function productB()
    {
        return $this->belongsTo(DtMasterProduct::class, 'product_b_id');
    }
}
