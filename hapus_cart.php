<?php
session_start();
include 'koneksi.php';

// Pastikan session id_user ada
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit;
}

$id_user   = $_SESSION['id'];
$id_produk = $_POST['id_produk']; // Ini sekarang cocok dengan form cart.php

$hapus = $koneksi->prepare("DELETE FROM cart WHERE id_user=? AND id_produk=?");
$hapus->execute([$id_user, $id_produk]);

header("Location: index.php");
exit;