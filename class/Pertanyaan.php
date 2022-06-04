<?php
class Pertanyaan
{
    // Koneksi
    private $conn;
    // Tabel
    private $db_table = "tbl_pertanyaan";
    // Kolom
    public $id;
    public $pertanyaan;
    public $opsi_benar;
    public $id_kategori;
    public $jenis_kategori;
    // Koneksi DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Ambil Seluruh
    public function ambilPertanyaan()
    {
        $sqlQuery = "SELECT " . $this->db_table . ".id, " . $this->db_table . ".pertanyaan, " . $this->db_table . ".opsi_benar, tbl_kategori.jenis_kategori FROM " . $this->db_table . " INNER JOIN tbl_kategori ON " . $this->db_table . ".id_kategori=tbl_kategori.id";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // Ambil Pertanyaan dengan kategori
    public function ambilPertanyaanDenganKategori()
    {
        $sqlQuery = "SELECT " . $this->db_table . ".id, " . $this->db_table . ".pertanyaan, " . $this->db_table . ".opsi_benar,  " . $this->db_table . ".id_kategori, tbl_kategori.jenis_kategori FROM " . $this->db_table . " INNER JOIN tbl_kategori ON " . $this->db_table . ".id_kategori=tbl_kategori.id WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id_kategori);
        $stmt->execute();
        return $stmt;
    }
    // Tambah
    public function tambahPertanyaan()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        pertanyaan = :pertanyaan, 
                        opsi_benar = :opsi_benar, 
                        id_kategori = :id_kategori";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->pertanyaan = htmlspecialchars(strip_tags($this->pertanyaan));
        $this->opsi_benar = htmlspecialchars(strip_tags($this->opsi_benar));
        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));

        // bind data
        $stmt->bindParam(":pertanyaan", $this->pertanyaan);
        $stmt->bindParam(":opsi_benar", $this->opsi_benar);
        $stmt->bindParam(":id_kategori", $this->id_kategori);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function ambilSatuPertanyaan()
    {
        $sqlQuery = "SELECT
                        id, 
                        pertanyaan, 
                        opsi_benar, 
                        id_kategori
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->pertanyaan = $dataRow['pertanyaan'];
        $this->opsi_benar = $dataRow['opsi_benar'];
        $this->id_kategori = $dataRow['id_kategori'];
    }
    // UPDATE
    public function perbaruiPertanyaan()
    {

        $sqlQuery = "UPDATE tbl_pertanyaan SET pertanyaan=:pertanyaan,opsi_benar=:opsi_benar,id_kategori=:id_kategori WHERE id=:id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->pertanyaan = htmlspecialchars(strip_tags($this->pertanyaan));
        $this->opsi_benar = htmlspecialchars(strip_tags($this->opsi_benar));
        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));
        $this->id = htmlspecialchars(strip_tags($this->id));


        // bind data
        $stmt->bindParam(":pertanyaan", $this->pertanyaan);
        $stmt->bindParam(":opsi_benar", $this->opsi_benar);
        $stmt->bindParam(":id_kategori", $this->id_kategori, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function hapusPertanyaan()
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
