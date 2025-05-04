<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode(["message" => "ok"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents("php://input");

    // Ghi log nếu cần
    file_put_contents("zalo_log.txt", date('c') . " - " . $data . "\n", FILE_APPEND);

    // Gửi request đến n8n webhook thật (không dùng webhook-test)
    $n8n_url = 'https://safeking.app.n8n.cloud/webhook/zalo-login-callback';

    $ch = curl_init($n8n_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // Trả về phản hồi của n8n
    header('Content-Type: application/json');
    echo $response;
    exit;
}
?>
