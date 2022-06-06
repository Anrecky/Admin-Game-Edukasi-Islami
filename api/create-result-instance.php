<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/Hasil.php';

$database = new Database();
$db = $database->getConnection();
$item = new Hasil($db);
$data = json_decode(file_get_contents("php://input"));

$item->id_kategori = $data->id_kategori;

if ($item->tambahHasilID()) {
    http_response_code(201);
    $dt = new DateTime($item->tgl_waktu, new DateTimeZone('Asia/Jakarta'));
    $hasil = array(
        "id" => $item->id,
        "categoryId" => $item->id_kategori,
        "score" => $item->skor,
        "dateTime" => $dt->format('Y-m-d\TH:i:s'),
    );
    echo json_encode($hasil);
} else {
    http_response_code(409);
    echo 'Hasil could not be created.';
}
