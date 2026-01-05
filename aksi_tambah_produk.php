<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$nama_produk   = $_POST['nama_produk'];
$harga         = $_POST['harga'];
$harga_diskon  = $_POST['harga_diskon'];
$deskripsi     = $_POST['deskripsi'];
$spesifikasi   = $_POST['spesifikasi'];
$gambar        = $_FILES['gambar']['name'];

/* Upload gambar */
$gambar = $_FILES['gambar']['name'];
$tmp    = $_FILES['gambar']['tmp_name'];

$folder = "assets/img/";
move_uploaded_file($tmp, $folder . $gambar);

/* Simpan ke database */
$query = $koneksi->prepare("
    INSERT INTO produk 
    (nama_produk, harga, harga_diskon, gambar, deskripsi, spesifikasi)
    VALUES (?, ?, ?, ?, ?, ?)
");

$query->execute([
    $nama_produk,
    $harga,
    $harga_diskon,
    $gambar,
    $deskripsi,
    $spesifikasi
]);

header("Location: index.php");
exit;
