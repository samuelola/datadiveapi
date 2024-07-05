<?php

$head = array(
    'Authorization: Bearer FLWSECK-b2ab628190693d48f1a979f270168a86-X',
    'Content-Type: application/json',
);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.flutterwave.com/v3/banks/ng',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => $head,
));

$res = curl_exec($curl);

//curl_close($curl);

$data = json_decode($res, true);

echo $res;
