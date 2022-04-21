<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';
    protected $fillable = [
        'id_driver',
        'nama_driver', 
        'alamat', 
        'tgl_lahir', 
        'jenis_kelamin', 
        'email', 
        'no_telp',
        'bahasa', 
        'status_driver', 
        'password', 
        'tarif_driver', 
        'rerata_rating', 
        'url_sim', 
        'url_surat_bebas_napza', 
        'url_surat_kesehatan_jiwa', 
        'url_surat_kesehatan_jasmani',
        'url_skck', 
        'url_foto'
    ];
    public function add_drivers(){
        return $this->hasMany(Transaction::class);
    }
    use HasFactory;
}
