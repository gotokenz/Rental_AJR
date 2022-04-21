<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner_Car extends Model
{
    protected $table = 'owner_cars';
    protected $primaryKey = 'id_pemilik';
    protected $fillable = [
        'status_pemilik',
        'nama_pemilik', 
        'no_ktp', 
        'alamat', 
        'no_telp'
    ];
    public function owners(){
        return $this->hasMany(Cars::class);
    }
    use HasFactory;
}
