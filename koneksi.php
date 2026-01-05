<?php
$servername = '127.0.0.1';
$userdb = "root";
$password = "";

try{
    $koneksi = new PDO("mysql:host=$servername;dbname=triple3", $userdb ,$password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Koneksi Gagal : ".$e->getMessage();
}
?>
