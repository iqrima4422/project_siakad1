<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa_Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_matakuliah';

    //many to many from mahasiswa_matakuliah to mahasiswa
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }

    //many to many from mahasiswa_matakuliah to matakuliah
    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class);
    }
}
