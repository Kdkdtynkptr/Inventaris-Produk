<?php
require_once 'classes/inventaris.php';
$sistem = new Inventaris();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk_id = (int)$_POST['produk_id'];
    $jumlah = (int)$_POST['jumlah'];
    
    $pesan = $sistem->catatTransaksi($produk_id, $jumlah);
    header("Location: index.php?pesan=" . urlencode($pesan));
    exit();
}
?>