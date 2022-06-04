<?php
class Hasil
{
    // Koneksi
    private $conn;
    // Tabel
    private $db_table = "tbl_hasil";
    // Kolom
    public $id;
    public $id_kategori;
    public $skor;
    public $tgl_waktu;

    // Koneksi DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Ambil Seluruh
    public function ambilHasil()
    {
        $sqlQuery = "SELECT tbl_h.id, tbl_h.skor, tbl_h.tgl_waktu, tbl_k.jenis_kategori FROM " . $this->db_table . " AS tbl_h RIGHT JOIN tbl_kategori AS tbl_k ON tbl_h.id = tbl_k.id ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // Tambah
    public function tambahHasilID()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET id_kategori = :id_kategori";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->id_kategori = intval(htmlspecialchars(strip_tags($this->id_kategori)));

        // bind data
        $stmt->bindParam(":id_kategori", $this->id_kategori, PDO::PARAM_INT);

        if ($stmt->execute()) {
            try {
                $this->id = $this->conn->lastInsertId();
                $this->ambilSatuHasil();
                return true;
            } catch (\Throwable $th) {
                return $th;
            }
        }
        return false;
    }
    // Tambah
    public function tambahHasil()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET id_kategori = :id_kategori";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->jenis_kategori = intval(htmlspecialchars(strip_tags($this->jenis_kategori)));

        // bind data
        $stmt->bindParam(":id_kategori", $this->id_kategori, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function ambilSatuHasil()
    {
        $sqlQuery = "SELECT id, id_kategori, skor, tgl_waktu FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $dataRow['id'];
        $this->id_kategori = $dataRow['id_kategori'];
        $this->skor = $dataRow['skor'];
        $this->tgl_waktu = $dataRow['tgl_waktu'];
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
