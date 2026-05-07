<?php
require_once 'classes/inventaris.php';
$sistem = new Inventaris();

$dataProduk = $sistem->getSemuaProduk();
$dataTransaksi = $sistem->getRekapTransaksi();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Inventaris</title>
</head>
<body>
    <h1>Dashboard Inventaris Toko</h1>
    
    <?php
    if (isset($_GET['pesan'])) {
        echo "<h3>Pesan: " . htmlspecialchars($_GET['pesan']) . "</h3><br>";
    }
    ?>

    <h2>Tambah Stok Produk</h2>
    <form method="POST" action="proses_produk.php">
        Nama Produk:<br>
        <input type="text" name="nama" required><br><br>
        
        Kategori:<br>
        <select name="kategori" required>
            <option value="Laptop">Laptop</option>
            <option value="Smartphone">Smartphone</option>
        </select><br><br>

        Stok Awal:<br>
        <input type="number" name="stok" min="0" required><br><br>

        Harga:<br>
        <input type="number" name="harga" min="0" step="0.01" required><br><br>

        <button type="submit">Tambah Produk</button>
    </form>

    <br><hr><br>

    <h2>Data Stok Produk</h2>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Status</th>
        </tr>
        <?php while($row = $dataProduk->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <?php 
                if($row['stok'] < 5) { 
                    echo "<b>[Stok Menipis]</b>"; 
                } else { 
                    echo "Aman"; 
                } 
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br><hr><br>

    <h2>Keluarkan Barang</h2>
    <form method="POST" action="proses_transaksi.php">
        Pilih Produk:<br>
        <select name="produk_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php 
            $dataProdukDropdown = $sistem->getSemuaProduk();
            while($p = $dataProdukDropdown->fetch_assoc()) { 
                echo "<option value='" . $p['id'] . "'>" . $p['nama'] . " (Stok: " . $p['stok'] . ")</option>";
            } 
            ?>
        </select><br><br>

        Jumlah Keluar:<br>
        <input type="number" name="jumlah" min="1" required><br><br>

        <button type="submit">Proses Transaksi</button>
    </form>

    <br><hr><br>

    <h2>Rekap Transaksi Keluar</h2>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Jumlah Terjual</th>
        </tr>
        <?php while($row = $dataTransaksi->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['jumlah_keluar'] ?> unit</td>
        </tr>
        <?php } ?>
    </table>
<br><br><br><br>
</body>
</html>