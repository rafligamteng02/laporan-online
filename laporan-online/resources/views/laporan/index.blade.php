<!DOCTYPE html>
<html>
<head>
    <title>Daftar Laporan</title>
</head>
<body>
<h1>Daftar Laporan</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<a href="{{ route('laporan.create') }}">+ Tambah Laporan</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Deskripsi</th>
        <th>Foto</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @foreach ($laporans as $laporan)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $laporan->nama }}</td>
        <td>{{ $laporan->alamat }}</td>
        <td>{{ $laporan->deskripsi }}</td>
        <td>
            @if($laporan->foto)
                <img src="{{ asset('storage/foto/'.$laporan->foto) }}" width="80">
            @else
                <i>Tidak ada foto</i>
            @endif
        </td>
        <td>{{ $laporan->tanggal }}</td>
        <td>
            <a href="{{ route('laporan.edit', $laporan->id) }}">Edit</a> |
            <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
