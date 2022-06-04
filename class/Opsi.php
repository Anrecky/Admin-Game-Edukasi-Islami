<?php
class Opsi
{
    // Koneksi
    private $conn;
    // Tabel
    private $db_table = "tbl_opsi";
    // Kolom
    public $id;
    public $opsi;
    public $id_kategori;
    public $jenis_kategori;
    // Koneksi DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Ambil Seluruh
    public function ambilOpsi()
    {
        $sqlQuery = "SELECT " . $this->db_table . ".id," . $this->db_table . ".opsi , tbl_kategori.jenis_kategori FROM " . $this->db_table . " INNER JOIN tbl_kategori ON " . $this->db_table . ".id_kategori=tbl_kategori.id";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    // Ambil Opsi dengan kategori
    public function ambilOpsiDenganKategori()
    {
        $sqlQuery = "SELECT " . $this->db_table . ".id, " . $this->db_table . ".opsi, " . $this->db_table . ".id_kategori, tbl_kategori.jenis_kategori FROM " . $this->db_table . " INNER JOIN tbl_kategori ON " . $this->db_table . ".id_kategori=tbl_kategori.id WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id_kategori);
        $stmt->execute();
        return $stmt;
    }
    // Ambil 3 Opsi Yang Bukan Opsi Benar Dengan Kategori
    public function ambilOpsiBukanOpsiBenarDenganKategori($opsiBenar)
    {
        $sqlQuery = "SELECT " . $this->db_table . ".opsi FROM " . $this->db_table . " INNER JOIN tbl_kategori ON " . $this->db_table . ".id_kategori=tbl_kategori.id WHERE id_kategori = ? AND opsi != ? ORDER BY RAND() LIMIT 3";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id_kategori);
        $stmt->bindParam(2, $opsiBenar);
        $stmt->execute();
        return $stmt;
    }
    // Tambah
    public function tambahOpsi()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        opsi = :opsi, 
                        id_kategori = :id_kategori";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->opsi = htmlspecialchars(strip_tags($this->opsi));
        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));

        // bind data
        $stmt->bindParam(":opsi", $this->opsi);
        $stmt->bindParam(":id_kategori", $this->id_kategori, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function ambilSatuOpsi()
    {
        $sqlQuery = "SELECT
                        id, 
                        opsi, 
                        id_kategori, 
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       id = ?
                    LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->opsi = $dataRow['opsi'];
        $this->id_kategori = $dataRow['id_kategori'];
    }
    // UPDATE
    public function perbaruiOpsi()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET opsi=:opsi, id_kategori=:id_kategori WHERE id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->opsi = htmlspecialchars(strip_tags($this->opsi));
        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":opsi", $this->opsi);
        $stmt->bindParam(":id_kategori", $this->id_kategori, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function hapusOpsi()
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
