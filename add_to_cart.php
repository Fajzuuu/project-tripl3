<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
  header("Location: index.php");
  exit;
}

$id_user = $_SESSION['id'];
$id_produk = $_POST['id_produk'];

// cek apakah produk sudah ada di cart
$cek = $koneksi->prepare("SELECT * FROM cart WHERE id_user=? AND id_produk=?");
$cek->execute([$id_user, $id_produk]);
  
if ($cek->rowCount() > 0) {
  // jika sudah ada, tambah qty
  $update = $koneksi->prepare(
    "UPDATE cart SET qty = qty + 1 WHERE id_user=? AND id_produk=?"
  );
  $update->execute([$id_user, $id_produk]);
} else {
  // jika belum ada
  $insert = $koneksi->prepare(
    "INSERT INTO cart (id_user, id_produk, qty) VALUES (?, ?, 1)"
  );
  $insert->execute([$id_user, $id_produk]);
}

header("Location: index.php");
exit;