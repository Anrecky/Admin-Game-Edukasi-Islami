<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/Hasil.php';

$database = new Database();
$db = $database->getConnection();

$item = new Hasil($db);

$data = json_decode(file_get_contents("php://input"));

$item->id = $data->id;

if (is_null($item->id) || empty($item->id)) {
    http_response_code(400);
    echo json_encode("Result ID is required!");
}

// result values
$item->id_kategori = $data->id_kategori;
$item->skor = $data->skor;
$item->tgl_waktu = date_create_from_format('Y-m-d\TH:i:s', strip_tags($data->tgl_waktu));

$updateResult = $item->perbaruiHasil();
$res = null;
if ($updateResult == "yes") {
    $res = array("message" => "Successfully updated result with id: $item->id!!!", "status" => 200);
    http_response_code(200);
} elseif ($updateResult == "no") {
    http_response_code(304);
} else {
    $res = array("message" => "Failed to updated result with the id $item->id not found!!!", "status" => 404);
    http_response_code(404);
}
print_r(json_encode($res));