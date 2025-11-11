<!DOCTYPE html>
<html>
<head>
    <title>Tambah Laporan</title>
</head>
<body>
<h1>Tambah Laporan</h1>

<form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Alamat:</label><br>
    <input type="text" name="alamat" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="4" required></textarea><br><br>

    <label>Foto:</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" required><br><br>

    <button type="submit">Simpan</button>
</form>

</body>
</html>
