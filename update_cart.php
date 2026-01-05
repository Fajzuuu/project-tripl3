<?php
session_start();
include 'koneksi.php';

// Cek login & session id_user
if (!isset($_SESSION['id'])) {
  header("Location: index.php"); // Redirect jika tidak ada session
  exit;
}

$id_user   = $_SESSION['id'];
$id_produk = $_POST['id_produk']; // Ini sekarang akan cocok dengan form di cart.php
$aksi      = $_POST['aksi'];

if ($aksi === 'tambah') {
  // Cek apakah produk sudah ada (preventif)
  $query = $koneksi->prepare("UPDATE cart SET qty = qty + 1 WHERE id_user = ? AND id_produk = ?");
  $query->execute([$id_user, $id_produk]);

} elseif ($aksi === 'kurang') {
  $cek = $koneksi->prepare("SELECT qty FROM cart WHERE id_user=? AND id_produk=?");
  $cek->execute([$id_user, $id_produk]);
  $data = $cek->fetch();

  if ($data && $data['qty'] > 1) {
    $update = $koneksi->prepare("UPDATE cart SET qty = qty - 1 WHERE id_user=? AND id_produk=?");
    $update->execute([$id_user, $id_produk]);
  } else {
    // Jika qty 1 dikurang, maka hapus
    $hapus = $koneksi->prepare("DELETE FROM cart WHERE id_user=? AND id_produk=?");
    $hapus->execute([$id_user, $id_produk]);
  }
}

header("Location: index.php");
exit;