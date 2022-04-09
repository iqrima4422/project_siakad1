@extends('mahasiswa.layout')

@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">
        <div class="d-flex justify-content-center mt-1">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="d-flex justify-content-center my-5">
            <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
        </div>
        <div class="row mb-2">
            <ul class="" style="list-style-type: none;">
                <li class=""><b>Nama: </b>{{$daftar->mahasiswa->nama}}</li>
                <li class=""><b>Nim: </b>{{$daftar->mahasiswa->nim}}</li>
                <li class=""><b>Kelas: </b>{{$daftar->mahasiswa->kelas->nama_kelas}}</li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">SKS</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftar as $d)
                <tr scope="row">
                    <td>
                        {{$d->matakuliah->nama_matkul}}
                    </td>
                    <td>
                        {{$d->matakuliah->sks}}
                    </td>
                    <td>
                        {{$d->matakuliah->semester}}
                    </td>
                    <td>
                        {{$d ->nilai}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection