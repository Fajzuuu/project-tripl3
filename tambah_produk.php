<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Tambah Produk Baru</h3>

    <form action="aksi_tambah_produk.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Harga</label>
          <input type="number" name="harga" class="form-control" required>
        </div>

      <div class="mb-3">
        <label>Harga Diskon</label>
        <input type="number" name="harga_diskon" class="form-control">
      </div>


        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Spesifikasi</label>
            <textarea name="spesifikasi" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Gambar Produk</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            💾 Simpan Produk
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>
</div>

</body>
</html>
