<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(["message" => "ok"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ghi log lại nếu cần
    $data = file_get_contents("php://input");
    file_put_contents("zalo_log.txt", date('c') . " - " . $data . "\n", FILE_APPEND);

    // Trả về HTTP 200 OK để Zalo xác nhận webhook hợp lệ
    header('Content-Type: application/json');
    echo json_encode(["message" => "received"]);
    exit;
}
?>
