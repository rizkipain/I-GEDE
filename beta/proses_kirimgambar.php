<?php

if(!empty($_FILES['gambarnya']['tmp_name']) 
&& file_exists($_FILES['gambarnya']['tmp_name'])) {
$foto4 = base64_encode(file_get_contents($_FILES['gambarnya']['tmp_name']));
}


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.maxchat.id/demo7/api/messages/image",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"to": "628990754408", "image": "data:image/jpeg;base64,'.$foto4.'",
    "filename": "asdasdasd.gif",
    "caption": "asdasdasd"}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer AgEnUY5S8rraKMwFXviGNA",
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