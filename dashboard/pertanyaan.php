<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

include_once '../config/database.php';
include_once '../class/Pertanyaan.php';
include_once '../class/Opsi.php';
include_once '../class/Kategori.php';
include_once '../utils/url.php';

$database = new Database();
$db = $database->getConnection();

$items = new Pertanyaan($db);
$items2 = new Kategori($db);
$stmt = $items->ambilPertanyaan();
$stmt2 = $items2->ambilKategori();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists("delete", $_POST)) {
        $item = new Pertanyaan($db);
        $idpertanyaan = intval($_POST['idpertanyaan']);
        $item->id = $idpertanyaan;
        if ($item->hapusPertanyaan()) {
            header("refresh:0");
        } else {
            echo "Data could not be deleted";
        }
    } else {
        if ($_POST['form-method'] == "POST") {
            // collect value of input field
            $pertanyaan = $_POST['pertanyaan'];
            $idkategori = $_POST['idkategori'];
            $opsibenar = $_POST['opsibenar'];
            if (empty($pertanyaan) || empty($idkategori) || empty($opsibenar)) {
                echo "Kolom masih kosong!";
            } else {
                $item = new Pertanyaan($db);
                $item->pertanyaan = $pertanyaan;
                $item->id_kategori = $idkategori;
                $item->opsi_benar = $opsibenar;
                if ($item->tambahPertanyaan()) {
                    header("refresh:0");
                } else {
                    echo "Tidak Berhasil";
                }
            }
        } else {
            // collect value of input field
            $idpertanyaan = intval($_POST['idpertanyaan']);
            $pertanyaan = $_POST['pertanyaan'];
            $idkategori = intval($_POST['idkategori']);
            $opsibenar = $_POST['opsibenar'];

            if (empty($pertanyaan) || empty($idkategori) || empty($opsibenar) || empty($idpertanyaan)) {
                echo "Kolom masih kosong!";
            } else {
                $item = new Pertanyaan($db);
                $item->id = $idpertanyaan;
                $item->pertanyaan = $pertanyaan;
                $item->id_kategori = $idkategori;
                $item->opsi_benar = $opsibenar;
                if ($item->perbaruiPertanyaan()) {
                    header("refresh:0");
                } else {
                    echo "Tidak Berhasil";
                }
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
   <link rel="stylesheet" href="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/vendor/fontawesome-free-5.7.2-web/css/all.min.css"; ?>">
    <link href="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/vendor/bootstrap-5.0.2-dist/css/bootstrap.min.css"; ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/admin.css"; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/vendor/DataTables/datatables.min.css"; ?>" />

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
                            <a class="nav-link active" aria-current="page" href="<?php echo setUrl('/pertanyaan.php') ?>">
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
                           <a class="nav-link" href="<?php echo setUrl('/hasil.php') ?>">
                              <i class="fas fa-award"></i>
                                Hasil
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="container my-4">
                    <h2>Tabel Pertanyaan</h2>
                    <div class="table-responsive w-75">
                        <table id="tbl-data" class="table table-striped ">
                            <thead>
                                <tr class="bg-primary flex text-white">
                                    <th scope="col" class="col-1">id</th>
                                    <th scope="col" class="col-8">Pertanyaan</th>
                                    <th scope="col" class="col-1">Jawaban</th>
                                    <th scope="col" class="col-2">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['pertanyaan'] . "</td>";
                                    echo "<td>" . $row['opsi_benar'] . "</td>";
                                    echo "<td>" . $row['jenis_kategori'] . "</td>";
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pertanyaan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-pertanyaan" method="POST" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="form-method">
                        <input type="hidden" name="idpertanyaan" id="id-pertanyaan">
                        <div class="mb-3">
                            <label for="pertanyaan" class="col-form-label">Pertanyaan:</label>
                            <input type="text" name="pertanyaan" class="form-control" id="pertanyaan">
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="col-form-label">Kategori:</label>
                            <select name="idkategori" id="id-kategori" class="form-select" aria-label="Default select example">
                                <option selected value="" disabled>Pilih kategori</option>
                                <?php
                                while ($kategori = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . strval($kategori['id']) . "'>"  . $kategori['jenis_kategori'] . "</option>";
                                };
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="opsibenar" class="col-form-label">Jawaban:</label>
                            <input type="text" name="opsibenar" class="form-control" id="opsi-benar">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn-submit" class="btn btn-success">Tambah Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <form id="form-delete" class="visually-hidden" method="POST" action="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; ?>">
        <input value="true" type="hidden" name="delete">
        <input type="number" name="idpertanyaan" id="id-pertanyaan">
    </form>
    <script src="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/vendor/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"; ?>" ></script>
    <script type="text/javascript" src="<?php echo "http://".$_SERVER['HTTP_HOST']."/admin/vendor/DataTables/datatables.min.js"; ?>"></script>
    <script type="text/javascript" src="./pertanyaan.js"></script>
</body>

</html>