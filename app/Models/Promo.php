<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'kode_promo', 
        'jenis_promo', 
        'keterangan', 
        'diskon',
        'status_promo'
    ];
    public function promo_customers(){
        return $this->hasMany(Transaction::class);
    }
    use HasFactory;
}
