<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'id_customer',
        'nama_customer', 
        'alamat', 
        'tgl_lahir', 
        'jenis_kelamin',
        'email', 
        'no_telp', 
        'password', 
        'url_sim', 
        'url_kartu_identitas',
        'status_customer'
    ];

    public function add_customers(){
        return $this->hasMany(Transaction::class);
    }
    use HasFactory;
}
