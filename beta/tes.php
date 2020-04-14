<?php
$b64image = base64_encode(file_get_contents('https://api.mapbox.com/styles/v1/rizkipain/ck429io6v0qu91cphdi09ccdt/static/url-https%3A%2F%2Fi.ibb.co%2FzhMXNCN%2Ficonfinder-epicenter-r-86195.png(123.13,0.02)/123.13,0.02,7/700x700?logo=false&attribution=false&access_token=pk.eyJ1Ijoicml6a2lwYWluIiwiYSI6ImNrNDBscnA1OTAydG0zaW9hOGtxbHBseWsifQ.KR832-MFWx9UWqqpPPXcQg'));
echo $b64image;
?>