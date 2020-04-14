<?php

$peta = $_GET['alamat_peta'];
$b64image = base64_encode(file_get_contents('https://api.mapbox.com/styles/v1/rizkipain/ck429io6v0qu91cphdi09ccdt/static/url-https%3A%2F%2Fi.ibb.co%2FzhMXNCN%2Ficonfinder-epicenter-r-86195.png(123.13,0.02)/123.13,0.02,7/700x700?logo=false&attribution=false&access_token=pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg'));
echo $b64image;

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.maxchat.id/demo8/api/messages/image",
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 30,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"to": "6281342996744-1550663732", "image": "data:image/jpeg;base64,'.$b64image.'",
    "filename": "asdasdasd.gif",
    "caption": "asdasdasd"}',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer V6Cyiqy4SQfHwkCfqXoHdf",
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