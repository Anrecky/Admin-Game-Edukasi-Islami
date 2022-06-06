<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../class/Hasil.php';
include_once '../config/database.php';
include_once '../utils/url.php';

$database = new Database();
$db = $database->getConnection();
$item = new Hasil($db);
$idHasil = getParamFromUrl(basename($_SERVER['REQUEST_URI']), 'id');

if (is_null($idHasil) || empty($idHasil)) {
    http_response_code(400);
    echo json_encode("Result ID is required!");
}

$item->id = intval($idHasil);

if (!empty($item->hapusHasil())) {
    http_response_code(200);
    echo json_encode(array("message" => "Successfully deleted result with id: $item->id!!!", "status_code" => 200));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Result with the id $item->id not found!!!", "status_code" => 404));
}
