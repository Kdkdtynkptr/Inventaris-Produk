<?php
require_once 'classes/inventaris.php';
$sistem = new Inventaris();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $stok = (int)$_POST['stok'];
    $harga = (float)$_POST['harga'];
    
    $pesan = $sistem->tambahProduk($nama, $kategori, $stok, $harga);
    header("Location: index.php?pesan=" . urlencode($pesan));
    exit();
}
?>