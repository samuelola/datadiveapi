<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");

include_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data != []) {

        if (!empty($data['agent_id'])) {
            $agent_id = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

            if (!empty($data['amount'])) {
                $am = htmlentities(strip_tags($data['amount']), ENT_QUOTES, 'UTF-8');

                if (!empty($data['acct'])) {

                    $acct = htmlentities(strip_tags($data['acct']), ENT_QUOTES, 'UTF-8');

                    if (!empty($data['bank_code'])) {

                        $bank_code = htmlentities(strip_tags($data['bank_code']), ENT_QUOTES, 'UTF-8');

                        if (!empty($data['use_case'])) {

                            $use_case = htmlentities(strip_tags($data['use_case']), ENT_QUOTES, 'UTF-8');

                            $curl = curl_init();

                            $ref0 = $acct . '_' . date('Y-m-d H:i:s', time());
                            $ref1 = str_replace(' ', '_', $ref0);
                            $ref = str_replace(':', '-', $ref1);

                            $body = "{
                            \"amount\": $am,
                            \"narration\": \"DataDive Payment\",
                            \"currency\": \"NGN\",
                            \"account_number\": \"$acct\",
                            \"account_bank\": \"$bank_code\",
                            \"reference\": \"$ref\"
                            }";

                            $head = array(
                                'Authorization: Bearer FLWSECK-b2ab628190693d48f1a979f270168a86-X',
                                'Content-Type: application/json',
                            );

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.flutterwave.com/v3/transfers',
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

                            if ($r['status'] == 'success' && $r['message'] == 'Transfer Queued Successfully') {

                                $acct = $r['data']['account_number'];
                                $acct_name = $r['data']['full_name'];
                                $bank = $r['data']['bank_name'];
                                $amount = $r['data']['amount'];
                                $fee = $r['data']['fee'];
                                $narration = $r['data']['narration'];
                                $ref = $r['data']['reference'];
                                $transId = $r['data']['id'];

                                $sql = "INSERT INTO transactions_transfer(agent_id, use_case, acct, acct_name, bank, amount, fee, narration, ref, transId) VALUES ('$agent_id', '$use_case', '$acct', '$acct_name', '$bank', '$amount', '$fee', '$narration', '$ref', '$transId')";

                                if ($conn->query($sql)) {
                                    echo json_encode(array(
                                        "status" => "Ok",
                                        "message" => 'Success',
                                    ));

                                } else {
                                    echo json_encode(array(
                                        "status" => "Error",
                                        "message" => "An Error Occured",
                                        "error2" => $conn->errno,
                                    ));
                                }

                            } else {
                                echo json_encode(array(
                                    "status" => "Error",
                                    "ref" => $ref,
                                    "message" => "Transfer Failed",
                                    "data" => $r,
                                ));
                            }
                        } else {
                            echo json_encode(array(
                                "status" => "Error",
                                "message" => "Use Case is Required!",
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
                    "message" => "Amount is Required!",
                ));
            }
        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Agent Id is Required!",
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