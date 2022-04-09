<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa_Matakuliah;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KshController extends Controller
{
    // public function khs($id)
    //     {

    //         $daftar = Mahasiswa_MataKuliah::with("matakuliah")->where("mahasiswa_id", $id)->get();
    //         $daftar->mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiwa', $id)->first();
            
    //         $mahasiswa = Mahasiswa::find($id);
    //         return view('mahasiswa.khs', compact('daftar','mahasiswa'));
        
    //     }
}
