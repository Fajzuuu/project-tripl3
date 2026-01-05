<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

/* Ambil user berdasarkan username saja */
$sql = $koneksi->prepare(
    "SELECT * FROM users WHERE username=?"
);
$sql->execute([$username]);
$user = $sql->fetch(PDO::FETCH_ASSOC);

/* Cek password pakai password_verify */
if ($user && password_verify($password, $user['password'])) {

    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['id'] = $user['id'];

    header("Location: index.php");
    exit;

} else {
    echo "<script>alert('Username atau Password salah!');
    window.location='index.php';
    </script>";
}
