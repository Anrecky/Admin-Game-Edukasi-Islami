<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../class/Pertanyaan.php';
include_once '../config/database.php';
include_once '../class/Opsi.php';

$database = new Database();
$db = $database->getConnection();
$items = new Pertanyaan($db);
$items2 = new Opsi($db);
$items->id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : die();
$items2->id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : die();
$stmt = $items->ambilPertanyaanDenganKategori();

$questionArr = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options = array();

    extract($row);

    $stmt2 = $items2->ambilOpsiBukanOpsiBenarDenganKategori($opsi_benar);
    while ($rowOption = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        extract($rowOption);
        array_push($options, $opsi);
    };
    array_push($options, $opsi_benar);
    shuffle($options);
    $e = array(
        "id" => $id,
        "question" => $pertanyaan,
        "optionOne" => $options[0],
        "optionTwo" => $options[1],
        "optionThree" => $options[2],
        "optionFour" => $options[3],
        "answer" => $opsi_benar
    );
    array_push($questionArr, $e);

    // $options = array();
}

echo json_encode($questionArr, JSON_UNESCAPED_UNICODE);

// if ($itemCount2 > 0) {

//     $employeeArr2 = array();
//     $employeeArr2["body"] = array();
//     $employeeArr2["itemCount"] = $itemCount2;
//     while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
//         extract($row2);
//         $e2 = array(
//             "id" => $id,
//             "opsi" => $opsi,
//             "id_kategori" => $id_kategori,
//             "jenis_kategori" => $jenis_kategori
//         );
//         array_push($employeeArr2["body"], $e2);
//     }
//     echo json_encode($employeeArr2, JSON_UNESCAPED_UNICODE);
// } else {
//     http_response_code(404);
//     echo json_encode(
//         array("message" => "No record found.")
//     );
// }
