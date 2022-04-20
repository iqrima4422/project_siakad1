<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            // $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
            // return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);

        // yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
                $mahasiswa = Mahasiswa::with('kelas')->orderBy('nim', 'asc')->paginate(4); // Mengambil semua isi tabel
                return view('mahasiswa.index', ['mahasiswa' => $mahasiswa,]);
        
        //paginate
        // $paginate = Mahasiswa::paginate(4);
        // return view ('mahasiswa.index',['mahasiswa' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas'=> $kelas]);
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
        'Email' => ['required', 'email:dns', 'unique:mahasiswa'],
        'Alamat' => 'required',
        'Tanggal_Lahir' => 'required',
        'File'=>'required',
        ]);

        if($request->file('File')){
            $image_name = $request->file('File')->store('image', 'public');
        }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->Nim = $request->get('Nim');
        $mahasiswa->Nama = $request->get('Nama');
        
        $mahasiswa->photo_profile = $image_name;
        
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Alamat = $request->get('Alamat');
        $mahasiswa->Tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->Kelas_id = $request->get('Kelas');
        $mahasiswa->save();

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
        // code seelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);

            $Mahasiswa = Mahasiswa::with ('kelas')->where('nim', $nim)->first();
            //return view('mahasiswa.detail', ['Mahasiswa' =>'$mahasiswa']);
           
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
            $Mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();;
            $kelas = Kelas::all();
            return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
        }
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
            'File'=>'required',
            ]);

            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            $mahasiswa -> nim = $request->get('Nim');
            $mahasiswa -> nama = $request->get('Nama');
            
            if($mahasiswa->photo_profile && file_exists(storage_path('./app/public/'. $mahasiswa->photo_profile))){
                Storage::delete(['./public/', $mahasiswa->photo_profile]);
            }
    
            $image_name = $request->file('File')->store('image', 'public');
            
            $mahasiswa->photo_profile = $image_name;
            $mahasiswa -> kelas_id = $request->get('Kelas');
            $mahasiswa -> jurusan = $request->get('Jurusan');
            $mahasiswa -> email = $request->get('Email');
            $mahasiswa -> alamat = $request->get('Alamat');
            $mahasiswa -> tanggal_lahir = $request->get('Tanggal_Lahir');
            
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();
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
        $mahasiswa = Mahasiswa::where ('nama','like',"%".$cari."%")->paginate(3);
        // $kelas = Kelas::all();

        //Mengirim data ke view index.blade.php
        // return view ('mahasiswa.index', ['mahasiswa' => $mahasiswa]);
        return view('mahasiswa.index',[
            'mahasiswa' => $mahasiswa
        ]);


    }
    public function khs($nim)
        {

            $daftar = Mahasiswa_MataKuliah::with("matakuliah")->where("mahasiswa_id", $nim)->get();
            $daftar->mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            
            // $mahasiswa = Mahasiswa::find($id);
            // dd($daftar);
            return view('mahasiswa.khs', compact('daftar'));
        
        }

        public function cetak_pdf($Nim)
        {
            $daftar = Mahasiswa_MataKuliah::where("mahasiswa_id", $Nim)->get();
            $daftar->mahasiswa = Mahasiswa::with('kelas')->where("nim", $Nim)->first();
            $pdf = PDF::loadview('mahasiswa.cetak_pdf', compact('daftar'));
            return $pdf->stream();
        }
};
