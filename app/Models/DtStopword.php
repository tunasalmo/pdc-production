<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DtStopword extends Model
{
    protected $table    = 'dt_stopword';
    protected $fillable = ['word'];

    // Ambil semua stopword sebagai array string
    public static function getWords(): array
    {
        return self::pluck('word')->toArray();
    }
}