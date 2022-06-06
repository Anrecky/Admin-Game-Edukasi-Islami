<?php
class DetailHasil
{
    // Koneksi
    private $conn;
    // Tabel
    private $db_table = "tbl_hasil_detail";
    // Kolom
    public $id;
    public $id_pertanyaan;
    public $opsi_satu;
    public $opsi_dua;
    public $opsi_tiga;
    public $opsi_empat;
    public $id_kategori;
    public $opsi_dipilih;
    public $benar;
    public $id_hasil;
    public $tgl_waktu;

    // Koneksi DB
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // Ambil Seluruh
    public function ambilDetailHasil()
    {
        $sqlQuery = "SELECT tbl_h_d.id, tbl_p.pertanyaan, tbl_h_d.opsi_satu, tbl_h_d.opsi_dua, tbl_h_d.opsi_tiga, tbl_h_d.opsi_empat, tbl_k.jenis_kategori, tbl_h_d.opsi_dipilih, tbl_h_d.id_hasil, tbl_h_d.tgl_waktu FROM " . $this->db_table . " AS tbl_h_d LEFT JOIN tbl_pertanyaan AS tbl_p ON tbl_p.id = tbl_h_d.id_kategori RIGHT JOIN tbl_kategori AS tbl_k ON tbl_h_d.id_kategori = tbl_k.id ";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }
    public function ambilDetailHasilBerdasarkanIDHasil()
    {
        $sqlQuery = "SELECT tbl_h_d.id, tbl_h_d.benar,tbl_h_d.id_pertanyaan,tbl_p.pertanyaan, tbl_h_d.opsi_satu, tbl_h_d.opsi_dua, tbl_h_d.opsi_tiga, tbl_h_d.opsi_empat, tbl_k.jenis_kategori, tbl_h_d.opsi_dipilih, tbl_h_d.id_hasil, tbl_h_d.tgl_waktu FROM $this->db_table AS tbl_h_d INNER JOIN tbl_pertanyaan AS tbl_p ON tbl_p.id = tbl_h_d.id_pertanyaan RIGHT JOIN tbl_kategori AS tbl_k ON tbl_h_d.id_kategori = tbl_k.id WHERE tbl_h_d.id_hasil = :id_hasil";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":id_hasil", $this->id_hasil, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Tambah
    public function tambahDetailHasil()
    {
        $sqlQuery = "INSERT INTO tbl_hasil_detail SET id_pertanyaan = :id_pertanyaan, opsi_satu = :opsi_satu, opsi_dua =:opsi_dua, opsi_tiga = :opsi_tiga, opsi_empat = :opsi_empat, id_kategori = :id_kategori, benar = :benar ,opsi_dipilih = :opsi_dipilih, id_hasil = :id_hasil, tgl_waktu=:tgl_waktu";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->id_pertanyaan = intval(htmlspecialchars(strip_tags($this->id_pertanyaan)));
        $this->opsi_satu = htmlspecialchars(strip_tags($this->opsi_satu));
        $this->opsi_dua = htmlspecialchars(strip_tags($this->opsi_dua));
        $this->opsi_tiga = htmlspecialchars(strip_tags($this->opsi_tiga));
        $this->opsi_empat = htmlspecialchars(strip_tags($this->opsi_empat));
        $this->id_kategori = intval(htmlspecialchars(strip_tags($this->id_kategori)));
        $this->opsi_dipilih = htmlspecialchars(strip_tags($this->opsi_dipilih));
        $this->benar = intval(strip_tags($this->benar));
        $this->id_hasil = intval(htmlspecialchars(strip_tags($this->id_hasil)));

        // bind data
        $stmt->bindParam(":id_pertanyaan", $this->id_pertanyaan);
        $stmt->bindParam(":opsi_satu", $this->opsi_satu);
        $stmt->bindParam(":opsi_dua", $this->opsi_dua);
        $stmt->bindParam(":opsi_tiga", $this->opsi_tiga);
        $stmt->bindParam(":opsi_empat", $this->opsi_empat);
        $stmt->bindParam(":id_kategori", $this->id_kategori);
        $stmt->bindParam(":opsi_dipilih", $this->opsi_dipilih);
        $stmt->bindParam(":benar", $this->benar);
        $stmt->bindParam(":tgl_waktu", $this->tgl_waktu);
        $stmt->bindParam(":id_hasil", $this->id_hasil);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // READ single
    public function ambilSatuDetailHasil()
    {
        $sqlQuery = "SELECT id, jenis_kategori FROM " . $this->db_table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->jenis_kategori = $dataRow['jenis_kategori'];
    }
    // UPDATE
    public function perbaruiDetailHasil()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET id_kategori = :id_kategori, id_pertanyaan = :id_pertanyaan, opsi_satu = :opsi_satu, opsi_dua = :opsi_dua, opsi_tiga = :opsi_tiga, opsi_empat = :opsi_empat, opsi_dipilih = :opsi_dipilih, benar = :benar, id_hasil = :id_hasil, tgl_waktu = :tgl_waktu WHERE id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->id_kategori = htmlspecialchars(strip_tags($this->id_kategori));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":id_kategori", $this->id_kategori);
        $stmt->bindParam(":id_pertanyaan", $this->id_pertanyaan);
        $stmt->bindParam(":opsi_satu", $this->opsi_satu);
        $stmt->bindParam(":opsi_dua", $this->opsi_dua);
        $stmt->bindParam(":opsi_tiga", $this->opsi_tiga);
        $stmt->bindParam(":opsi_empat", $this->opsi_empat);
        $stmt->bindParam(":opsi_dipilih", $this->opsi_dipilih);
        $stmt->bindParam(":benar", $this->benar);
        $stmt->bindParam(":id_hasil", $this->id_hasil);
        $stmt->bindParam(":tgl_waktu", $this->tgl_waktu);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // DELETE
    function hapusDetailHasil()
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
