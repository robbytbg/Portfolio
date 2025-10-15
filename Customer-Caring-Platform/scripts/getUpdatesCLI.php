<?php
$bot_api_key  = '7121786806:AAGSs6jIkZ0uG4xctl8N_BqD5lQV416Yb1s';
$bot_username = 'Mfa_telBot';
$chat_id = '6273505374';
$message = ':3';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$bot_api_key/sendMessage");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'chat_id' => $chat_id,
    'text'    => $message,
]));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
curl_setopt($ch, CURLOPT_CAINFO, "C:\\xampp2\\php\\cacert-2024-07-02.pem");

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    echo 'cURL output: ' . $response;
}
curl_close($ch);
