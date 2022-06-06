<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

include_once '../config/database.php';
include_once '../class/Hasil.php';
include_once '../class/DetailHasil.php';
include_once '../class/Kategori.php';
include_once '../class/Pertanyaan.php';
include_once '../utils/url.php';

$database = new Database();
$db = $database->getConnection();

$item = new Hasil($db);
$items2 = new Kategori($db);
$items3 = new DetailHasil($db);
$items4 = new Pertanyaan($db);

$idHasil = getParamFromUrl(basename($_SERVER['REQUEST_URI']), 'id');

$item->id = intval($idHasil);
$item->ambilSatuHasil();

$stmt2 = $items2->ambilKategori();

$items3->id_hasil = intval($idHasil);
$stmt3 = $items3->ambilDetailHasilBerdasarkanIDHasil();

$items4->id_kategori = $item->id_kategori;
$stmt4 = $items4->ambilPertanyaanDenganKategori();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists("delete", $_POST)) {
        $detail_hasil = new DetailHasil($db);
        $id_detail_hasil = intval($_POST['id_detail_hasil']);
        $detail_hasil->id = $id_detail_hasil;
        if ($detail_hasil->hapusDetailHasil()) {
            header("refresh:0");
        } else {
            echo "Data could not be deleted";
        }
    } else {
        if ($_POST['form-method'] == "POST") {
            $idkategori = intval($_POST['id_kategori']);
            $tgl_waktu = $_POST['tgl_waktu'];
            $id_pertanyaan = intval($_POST['pertanyaan']);
            $opsi_satu = $_POST['opsi_satu'];
            $opsi_dua = $_POST['opsi_dua'];
            $opsi_tiga = $_POST['opsi_tiga'];
            $opsi_empat = $_POST['opsi_empat'];
            $opsi_dipilih = $_POST['opsi_dipilih'];
            $benar = $_POST['benar'];

            $detailHasil = new DetailHasil($db);
            $detailHasil->id_pertanyaan = $id_pertanyaan;
            $detailHasil->opsi_satu = $opsi_satu;
            $detailHasil->opsi_dua = $opsi_dua;
            $detailHasil->opsi_tiga = $opsi_tiga;
            $detailHasil->opsi_empat = $opsi_empat;
            $detailHasil->id_kategori = $idkategori;
            $detailHasil->opsi_dipilih = $opsi_dipilih;
            $detailHasil->benar = intval($benar);
            $detailHasil->id_hasil = intval($item->id);
            $detailHasil->tgl_waktu = $tgl_waktu;

            if ($detailHasil->tambahDetailHasil()) {
                header("refresh:0");
            } else {
                echo "Tidak Berhasil";
            }
        } else {
            // collect value of input field
            $id_detail_hasil = intval($_POST['id_detail_hasil']);
            $idkategori = intval($_POST['id_kategori']);
            $tgl_waktu = $_POST['tgl_waktu'];
            $id_pertanyaan = intval($_POST['pertanyaan']);
            $opsi_satu = $_POST['opsi_satu'];
            $opsi_dua = $_POST['opsi_dua'];
            $opsi_tiga = $_POST['opsi_tiga'];
            $opsi_empat = $_POST['opsi_empat'];
            $opsi_dipilih = $_POST['opsi_dipilih'];
            $benar = $_POST['benar'];

            $detailHasil = new DetailHasil($db);
            $detailHasil->id = $id_detail_hasil;
            $detailHasil->id_pertanyaan = $id_pertanyaan;
            $detailHasil->opsi_satu = $opsi_satu;
            $detailHasil->opsi_dua = $opsi_dua;
            $detailHasil->opsi_tiga = $opsi_tiga;
            $detailHasil->opsi_empat = $opsi_empat;
            $detailHasil->id_kategori = $idkategori;
            $detailHasil->opsi_dipilih = $opsi_dipilih;
            $detailHasil->benar = intval($benar);
            $detailHasil->id_hasil = intval($item->id);
            $detailHasil->tgl_waktu = $tgl_waktu;
            if ($detailHasil->perbaruiDetailHasil()) {
                header("refresh:0");
            } else {
                header("refresh:0");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Halaman Admin Data Pertanyaan | Game Edukasi Islami (Giovani)</title>
    <link rel="stylesheet" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/fontawesome-free-5.7.2-web/css/all.min.css"; ?>">
    <link href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css"; ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/admin.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/DataTables/datatables.min.css"; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css"; ?>" />

</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Game Edukasi Islami</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../logout.php">Keluar</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo setUrl('/pertanyaan.php') ?>">
                                <i class="fas fa-scroll"></i>
                                Pertanyaan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo setUrl('/opsi.php') ?>">
                                <i class="fas fa-th-large"></i>
                                Opsi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo setUrl('/kategori.php') ?>">
                                <i class="fas fa-shapes"></i>
                                Kategori
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo setUrl('/hasil.php') ?>">
                                <i class="fas fa-award"></i>
                                Hasil (Detail)
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="container my-4">
                    <h2>Tabel Detail Hasil Dengan ID Hasil: <b><?php echo $idHasil; ?></b></h2>
                    <div class="card p-3 shadow-sm table-responsive">
                        <table id="tbl-data" class="table table-striped ">
                            <thead>
                                <tr class="bg-primary flex text-white">
                                    <th scope="col" class="col-1">ID</th>
                                    <th scope="col" class="col">Pertanyaan</th>
                                    <th scope="col" class="col-1">Jenis Kategori</th>
                                    <th scope="col" class="col-1">Opsi Satu</th>
                                    <th scope="col" class="col-1">Opsi Dua</th>
                                    <th scope="col" class="col-1">Opsi Tiga</th>
                                    <th scope="col" class="col-1">Opsi Empat</th>
                                    <th scope="col" class="col-1">Opsi Dipilih</th>
                                    <th scope="col" class="col-1">Benar?</th>
                                    <th scope="col" class="col-2">Tanggal/Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td> {$row["id"]} </td>";
                                    echo "<td data-order='{$row["id_pertanyaan"]}' data-id='{$row["id_pertanyaan"]}'>{$row["pertanyaan"]}</td>";
                                    echo "<td>{$row["jenis_kategori"]}</td>";
                                    echo "<td>{$row["opsi_satu"]}</td>";
                                    echo "<td>{$row["opsi_dua"]}</td>";
                                    echo "<td>{$row["opsi_tiga"]}</td>";
                                    echo "<td>{$row["opsi_empat"]}</td>";
                                    echo "<td>{$row["opsi_dipilih"]}</td>";
                                    echo "<td>" . ($row["benar"] ? "Benar" : "Salah") . "</td>";
                                    echo "<td>{$row["tgl_waktu"]}  </td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <div class="modal fade" id="modalDetailHasil" tabindex="-1" aria-labelledby="labelModalDetailHasil" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelModalDetailHasil">Perbaharui Hasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-detail_hasil" method="POST" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?id=$item->id"; ?>">
                        <input type="hidden" name="form-method">
                        <input type="hidden" name="id_detail_hasil" id="id_detail_hasil">

                        <div class="mb-3">
                            <label for="pertanyaan" class="col-form-label">Pertanyaan:</label>
                            <select name="pertanyaan" id="pertanyaan" class="form-select" aria-label="Pilih pertanyaan">
                                <option selected value="" disabled>Pilih pertanyaan</option>
                                <?php
                                while ($pertanyaan = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . strval($pertanyaan['id']) . "'>"  . $pertanyaan['pertanyaan'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="col-form-label">Kategori:</label>
                            <input type="text" name="kategori" class="form-control" value="<?php echo $item->jenis_kategori; ?>" id="kategori" disabled>
                            <input type="hidden" name="id_kategori" id="id_kategori" value="<?php echo $item->id_kategori; ?>">
                        </div>

                        <div class="mb-3 row">
                            <div class="col-6 mb-3">
                                <label for="opsi_satu" class="col-form-label">Opsi Satu:</label>
                                <input type="text" name="opsi_satu" class="form-control" id="opsi_satu">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="opsi_dua" class="col-form-label">Opsi Dua:</label>
                                <input type="text" name="opsi_dua" class="form-control" id="opsi_dua">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="opsi_tiga" class="col-form-label">Opsi Tiga:</label>
                                <input type="text" name="opsi_tiga" class="form-control" id="opsi_tiga">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="opsi_empat" class="col-form-label">Opsi Empat:</label>
                                <input type="text" name="opsi_empat" class="form-control" id="opsi_empat">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="benar" class="col-form-label">Benar/Salah:</label>
                                <select name="benar" id="benar" class="form-select" aria-label="Pilih Benar/Salah">
                                    <option selected value="1">Benar</option>
                                    <option value="0">Salah</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="opsi_dipilih" class="col-form-label">Opsi Dipilih:</label>
                                <input type="text" name="opsi_dipilih" class="form-control" id="opsi_dipilih">
                            </div>
                            <div class="col-8">
                                <label for="tgl_waktu" class="col-form-label">Tgl/Waktu:</label>
                                <input type="text" style="font-family:'Font Awesome 5 Free'" placeholder="&#xf073; Tanggal/Waktu" autocomplete="off" name="tgl_waktu" class="form-control" id="tgl_waktu">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit" class="btn btn-warning">Perbaharui Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <form id="form-delete" class="visually-hidden" method="POST" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?id=$item->id"; ?>">
        <input value="true" type="hidden" name="delete">
        <input type="number" name="id_detail_hasil" id="id_detail_hasil">
    </form>

    <script src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/DataTables/datatables.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/admin/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"; ?>"></script>
    <script type="text/javascript" src="./detail-hasil.js"></script>
</body>

</html>