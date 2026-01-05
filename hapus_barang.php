<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: index.php");
  exit;
}

include 'koneksi.php';

if (!isset($_GET['id_produk'])) {
  header("Location: index.php");
  exit;
}

$id = $_GET['id_produk'];

$stmt = $koneksi->prepare("DELETE FROM produk WHERE id_produk = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
