<?php
class KoneksiDB {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "InventarisToko_240040004";
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error . "<br>");
        }
    }
}
?>