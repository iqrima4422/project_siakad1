<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
            // $mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
            // $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(4);
            // return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);

        // paginate
        $paginate = Mahasiswa::paginate(4);
        return view ('mahasiswa.index',['mahasiswa' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Nama' => 'required',
                'Kelas' => 'required',
                'Jurusan' => 'required',
                'Email' => 'required',
                'Alamat' => 'required',
                'Tanggal_Lahir' => 'required',
            ]);

        //fungsi eloquent untuk menambah data
            Mahasiswa::create($request->all());
            
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
            $Mahasiswa = Mahasiswa::where('nim', $nim)->first();
            return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
            $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();
            return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Nama' => 'required',
                'Kelas' => 'required',
                'Jurusan' => 'required',
                'Email' => 'required',
                'Alamat' => 'required',
                'Tanggal_Lahir' => 'required',
                ]);
            //fungsi eloquent untuk mengupdate data inputan kita
                Mahasiswa::where('nim', $nim)
                ->update([
                'nim'=>$request->Nim,
                'nama'=>$request->Nama,
                'kelas'=>$request->Kelas,
                'jurusan'=>$request->Jurusan,
                'email'=>$request->Email,
                'alamat'=>$request->Alamat,
                'tanggal_lahir'=>$request->Tanggal_Lahir,
                ]);
            //jika data berhasil diupdate, akan kembali ke halaman utama
                return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
            Mahasiswa::where('nim', $nim)->delete();
            return redirect()->route('mahasiswa.index')
                -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function cari(Request $request)
    {
        //Menangkap data pencarian
        $cari = $request->cari;

        //Mengambil data nama dari tabel mahasiswa
        $mahasiswa = DB::table('mahasiswa')->where ('nama','like',"%".$cari."%")->paginate();
        
        //Mengirim data ke view index.blade.php
        return view ('mahasiswa.index', ['mahasiswa' => $mahasiswa]);
    }
};
