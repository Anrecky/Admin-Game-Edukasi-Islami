<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../class/Pertanyaan.php';
include_once '../config/database.php';
include_once '../class/Opsi.php';

$database = new Database();
$db = $database->getConnection();
$items = new Pertanyaan($db);
$items->id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : die();
$stmt = $items->ambilPertanyaanDenganKategori();

$questionArr = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    extract($row);

    $e = array(
        "id" => $id,
        "question" => $pertanyaan,
        "category" => $jenis_kategori,
        "answer" => $opsi_benar
    );
    array_push($questionArr, $e);

}

echo json_encode($questionArr, JSON_UNESCAPED_UNICODE);

