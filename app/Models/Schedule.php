<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = [
        'shift',
        'hari'
    ];
    public function schedules(){
        return $this->hasMany(Detail_Schedule::class);
    }
    use HasFactory;
}
