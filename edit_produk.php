<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

include 'koneksi.php';

if (!isset($_GET['id_produk'])) {
  echo "ID produk tidak ditemukan";
  exit;
}

$id = $_GET['id_produk'];

$stmt = $koneksi->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
  echo "Produk tidak ditemukan";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
  <h3 class="mb-4 text-warning">✏ Edit Produk</h3>

  <form action="update_produk.php" method="POST">
    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">

    <div class="mb-3">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk"
             class="form-control"
             value="<?= $produk['nama_produk'] ?>" required>
    </div>

    <div class="mb-3">
      <label>Harga Awal</label>
      <input type="number" name="harga"
             class="form-control"
             value="<?= $produk['harga'] ?>" required>
    </div>

    <div class="mb-3">
      <label>Harga</label>
      <input type="number" name="harga_diskon"
             class="form-control"
             value="<?= $produk['harga_diskon'] ?>">
    </div>

    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="3"><?= $produk['deskripsi'] ?></textarea>
    </div>

    <div class="mb-3">
      <label>Spesifikasi</label>
      <textarea name="spesifikasi" class="form-control" rows="3"><?= $produk['spesifikasi'] ?></textarea>
    </div>

    <button class="btn btn-warning">💾 Simpan Perubahan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </form>

</div>

</body>
</html>
