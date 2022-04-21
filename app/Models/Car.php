<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'id_aset_mobil';
    protected $fillable = [
        'id_pemilik',
        'nama_mobil', 
        'tipe', 
        'jenis_transmisi', 
        'jenis_bahan_bakar', 
        'warna',
        'volume_bagasi', 
        'fasilitas', 
        'kapasitas_penumpang', 
        'plat_nomor', 
        'nomor_stnk',
        'kategori_aset', 
        'harga_sewa', 
        'status_mobil', 
        'tgl_servis', 
        'mulai_kontrak',
        'selesai_kontrak', 
        'url_foto'
    ];
    public function aset_car(){
        return $this->belongTo(Owner_Car::class, 'id_pemilik');
    }
    public function rent_cars(){
        return $this->hasMany(Transaction::class);
    }
    use HasFactory;
}
