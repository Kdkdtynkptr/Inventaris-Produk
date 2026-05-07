<?php
require_once __DIR__ . '/../config/database.php';

class Inventaris extends KoneksiDB {
    public function tambahProduk($nama, $kategori, $stok, $harga) {
        if ($stok < 0) {
            return "Gagal: Stok tidak boleh negatif.";
        }

        $stmt = $this->conn->prepare("INSERT INTO produk (nama, kategori, stok, harga) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $nama, $kategori, $stok, $harga);
        
        if ($stmt->execute()) {
            return "Sukses: Produk ditambahkan.";
        }
        return "Gagal: Terjadi kesalahan.";
    }

    public function catatTransaksi($produk_id, $jumlah) {
        if ($jumlah <= 0) {
            return "Gagal: Jumlah tidak valid.";
        }

        $stmtCek = $this->conn->prepare("SELECT stok, nama FROM produk WHERE id = ?");
        $stmtCek->bind_param("i", $produk_id);
        $stmtCek->execute();
        $result = $stmtCek->get_result();
        
        if ($result->num_rows === 0) {
            return "Gagal: Produk tidak ditemukan.";
        }

        $row = $result->fetch_assoc();
        if ($row['stok'] < $jumlah) {
            return "Gagal: Stok tidak mencukupi.";
        }

        $stok_baru = $row['stok'] - $jumlah;
        $stmtUpdate = $this->conn->prepare("UPDATE produk SET stok = ? WHERE id = ?");
        $stmtUpdate->bind_param("ii", $stok_baru, $produk_id);
        $stmtUpdate->execute();

        $stmtTrans = $this->conn->prepare("INSERT INTO transaksi (produk_id, jumlah_keluar) VALUES (?, ?)");
        $stmtTrans->bind_param("ii", $produk_id, $jumlah);
        $stmtTrans->execute();

        return "Sukses: Transaksi dicatat.";
    }

    public function getSemuaProduk() {
        return $this->conn->query("SELECT * FROM produk");
    }

    public function getRekapTransaksi() {
        return $this->conn->query("SELECT t.tanggal, p.nama, t.jumlah_keluar FROM transaksi t JOIN produk p ON t.produk_id = p.id ORDER BY t.tanggal DESC");
    }
}
?>