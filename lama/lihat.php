<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.maxchat.id/demo1/api/messages",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"to": "628561234567", "text": "ini contoh pesan"}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer PLmQSbJ8cyGguvycgrj5fC",
    "Content-Type: application/json",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

?>