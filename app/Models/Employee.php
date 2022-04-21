<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'status_pegawai',
        'id_role',
        'nama_pegawai', 
        'alamat', 
        'tgl_lahir', 
        'jenis_kelamin',
        'email', 
        'no_telp', 
        'password', 
        'url_foto'
    ];
    public function emp_role(){
        return $this->belongTo(Role::class, 'id_role');
    }
    public function emps(){
        return $this->hasMany(Transaction::class);
    }
    use HasFactory;
}
