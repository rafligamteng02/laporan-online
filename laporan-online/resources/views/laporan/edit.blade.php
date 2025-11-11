<!DOCTYPE html>
<html>
<head>
    <title>Edit Laporan</title>
</head>
<body>
<h1>Edit Laporan</h1>

<form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Nama:</label><br>
    <input type="text" name="nama" value="{{ $laporan->nama }}" required><br><br>

    <label>Alamat:</label><br>
    <input type="text" name="alamat" value="{{ $laporan->alamat }}" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="4" required>{{ $laporan->deskripsi }}</textarea><br><br>

    <label>Foto:</label><br>
    @if($laporan->foto)
        <img src="{{ asset('storage/foto/'.$laporan->foto) }}" width="100"><br>
    @endif
    <input type="file" name="foto" accept="image/*"><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" value="{{ $laporan->tanggal }}" required><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
