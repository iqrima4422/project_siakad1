<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>KHS - {{ $daftar->mahasiswa->nama }} - {{ $daftar->mahasiswa->nim }}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <style>
    table tr td,
    table tr th{
      font-size: 9pt;
    }
  </style>
</head>
  <body>
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="text-center mt-2">
        <h5>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h5>
        <br>
        <h5 class="text-center">KARTU HASIL STUDI (KHS)</h5>
      </div>
    </div>
  </div>

  <div class="container">
    <p><b>Nama : </b> {{ $daftar->mahasiswa->nama }}</p>
    <p><b>NIM : </b> {{ $daftar->mahasiswa->nim }}</p>
    <p><b>Kelas : </b> {{ $daftar->mahasiswa->kelas->nama_kelas }}</p>
    <table class="table table-bordered">
      <tr>
        <th>Matakuliah</th>
        <th>SKS</th>
        <th>Semester</th>
        <th>Nilai</th>
      </tr>
      @if(!empty($daftar) && $daftar->count())
        @foreach($daftar as $row)
          <tr>
            <td>{{ $row->matakuliah->nama_matkul }}</td>
            <td>{{ $row->matakuliah->sks }}</td>
            <td>{{ $row->matakuliah->semester }}</td>
            <td>{{ $row->matakuliah->nilai }}</td>
          </tr>
        @endforeach
      @else
        <tr>
          <td class="text-center" colspan="10">There are no data.</td>
        </tr>
      @endif
    </table>
  </div>
</body>
</html>