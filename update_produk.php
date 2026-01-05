<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

include 'koneksi.php';

$id = $_POST['id_produk'];
$nama = $_POST['nama_produk'];
$harga = $_POST['harga'];
$harga_diskon = $_POST['harga_diskon'];
$deskripsi = $_POST['deskripsi'];
$spesifikasi = $_POST['spesifikasi'];

$query = $koneksi->prepare("
  UPDATE produk SET
    nama_produk = ?,
    harga = ?,
    harga_diskon = ?,
    deskripsi = ?,
    spesifikasi = ?
  WHERE id_produk = ?
");

$query->execute([
  $nama,
  $harga,
  $harga_diskon,
  $deskripsi,
  $spesifikasi,
  $id
]);

header("Location: detail_produk.php?id_produk=$id");
exit;
