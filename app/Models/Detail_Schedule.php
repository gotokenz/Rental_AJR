<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Schedule extends Model
{
    protected $table = 'detail_schedules';
    protected $fillable = [
        'id_jadwal',
        'id_pegawai'
    ];
    public function detail_schedules(){
        return $this->belongTo(Schedule::class, 'id_jadwal');
        return $this->belongTo(Employee::class, 'id_pegawai');
    }
    use HasFactory;
}
