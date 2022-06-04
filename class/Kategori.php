<?php
class Kategori
{
    // Koneksi
    private $conn;
    // Tabel
    private $db_table = "tbl_kategori";
    // Kolom
    public $id;
    public $jenis_kategori;
    // Koneksi DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Ambil Seluruh
    public function ambilKategori()
    {
        $sqlQuery = "SELECT " . $this->db_table . ".id," . $this->db_table . ".jenis_kategori FROM " . $this->db_table . " ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // Tambah
    public function tambahKategori()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET jenis_kategori = :jenis_kategori";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->jenis_kategori = htmlspecialchars(strip_tags($this->jenis_kategori));

        // bind data
        $stmt->bindParam(":jenis_kategori", $this->jenis_kategori);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function ambilSatuKategori()
    {
        $sqlQuery = "SELECT id, jenis_kategori FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->jenis_kategori = $dataRow['jenis_kategori'];
    }
    // UPDATE
    public function perbaruiKategori()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET jenis_kategori = :jenis_kategori WHERE id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->jenis_kategori = htmlspecialchars(strip_tags($this->jenis_kategori));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":jenis_kategori", $this->jenis_kategori);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function hapusKategori()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
