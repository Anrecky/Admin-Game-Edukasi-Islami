<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/DetailHasil.php';

$database = new Database();
$db = $database->getConnection();

$item = new DetailHasil($db);

$data = json_decode(file_get_contents("php://input"));


// // Detail Hasil
$item->id_pertanyaan = intval($data->id_pertanyaan);
$item->opsi_satu = $data->opsi_satu;
$item->opsi_dua = $data->opsi_dua;
$item->opsi_tiga = $data->opsi_tiga;
$item->opsi_empat = $data->opsi_empat;
$item->id_kategori = intval($data->id_kategori);
$item->benar = $data->benar;
$item->opsi_dipilih = $data->opsi_dipilih;
$item->id_hasil = intval($data->id_hasil);

if($item->tambahDetailHasil()){
    http_response_code(201);
    echo json_encode($item);
}else{
    http_response_code(409);
    echo json_encode($item);
}
    