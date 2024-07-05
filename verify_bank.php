<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");

include_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data != []) {

        if (!empty($data['acct'])) {

            $acct = htmlentities(strip_tags($data['acct']), ENT_QUOTES, 'UTF-8');

            if (!empty($data['bank_code'])) {

                $bank_code = htmlentities(strip_tags($data['bank_code']), ENT_QUOTES, 'UTF-8');

                $curl = curl_init();

                $body = "{
                        \"account_number\": \"$acct\",
                        \"account_bank\": \"$bank_code\"
                        }";

                $head = array(
                    'Authorization: Bearer FLWSECK-b2ab628190693d48f1a979f270168a86-X',
                    'Content-Type: application/json',
                );

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.flutterwave.com/v3/accounts/resolve',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => $head,
                ));

                $res = curl_exec($curl);

                curl_close($curl);

                $r = json_decode($res, true);

                if ($r['status'] == 'success' && $r['message'] == 'Account details fetched') {
                    
                  //  $r['account_number']

                    echo json_encode(array(
                        "status" => "Ok",
                        "message" => 'Success',
                        "details" => $r['data']
                    ));

                } else {
                    echo json_encode(array(
                        "status" => "Error",
                        "message" => "Account Details Invalid",
                    ));
                }

            } else {
                echo json_encode(array(
                    "status" => "Error",
                    "message" => "Bank Code is Required!",
                ));
            }

        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Account Number is Required!",
            ));
        }

    } else {
        echo json_encode(array(
            "status" => "Error",
            "message" => "All Fields is Required!",
        ));
    }

} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "Access Denied",
    ));
}
