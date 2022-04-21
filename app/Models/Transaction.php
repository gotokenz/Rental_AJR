<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'id_transaksi',
        'id_pegawai',
        'id_customer',
        'id_driver',
        'id_aset_mobil',
        'id_promo',
        'jenis_sewa', 
        'tgl_transaksi', 
        'tgl_mulai_sewa', 
        'tgl_selesai_sewa',
        'tgl_pengembalian', 
        'total_harga_sewa', 
        'status_transaksi', 
        'tgl_bayar',
        'metode_bayar',
        'total_diskon',
        'total_denda',
        'total_harga',
        'url_bukti_pembayaran',
        'rating_driver',
        'rating_perusahaan'
    ];
    public function data_transactions(){
        return $this->belongTo(Employee::class, 'id_pegawai');
        return $this->belongTo(Customer::class, 'id_customer');
        return $this->belongTo(Driver::class, 'id_driver');
        return $this->belongTo(Car::class, 'id_aset_mobil');
        return $this->belongTo(Promo::class, 'id_promo');
    }
    use HasFactory;
}
