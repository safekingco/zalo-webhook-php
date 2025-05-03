<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "Zalo webhook verified!";
    exit;
}

$data = file_get_contents("php://input");
file_put_contents("zalo_log.txt", date('c') . " - " . $data . "\n", FILE_APPEND);

$webhook_n8n = "https://safeking.app.n8n.cloud/webhook-test/zalo-login-callback";

$ch = curl_init($webhook_n8n);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo json_encode(["message" => "forwarded to n8n"]);
?>
