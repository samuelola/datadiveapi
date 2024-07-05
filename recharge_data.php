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

            if (!empty($data['ph'])) {

                $ph = htmlentities(strip_tags($data['ph']), ENT_QUOTES, 'UTF-8');

                if (!empty($data['use_case'])) {

                    $use_case = htmlentities(strip_tags($data['use_case']), ENT_QUOTES, 'UTF-8');

                    if (!empty($data['amount'])) {

                        $am = htmlentities(strip_tags($data['amount']), ENT_QUOTES, 'UTF-8');

                    } else {
                        $am = 100;
                    }

                    $curl = curl_init();

                    $ref0 = $ph . '_' . date('Y-m-d H:i:s', time());
                    $ref1 = str_replace(' ', '_', $ref0);
                    $ref = str_replace(':', '-', $ref1);
                    
                    $data = '';
                    $p = substr($ph, 0, 4);
                    
                    if($p == '0803' 
                    || $p == '0816'
                    || $p == '0903'
                    || $p == '0810'
                    || $p == '0806'
                    || $p == '0703'
                    || $p == '0813'
                    || $p == '0814'
                    || $p == '0906'
                    || $p == '0913'
                    || $p == '0916'
                    || $p == '0706'
                    ){
                        $data = 'mtn_sme_500mb';
                    } else if($p == '0907'
                    || $p == '0708'
                    || $p == '0802'
                    || $p == '0901'
                    || $p == '0902'
                    || $p == '0904'
                    || $p == '0812'
                    || $p == '0808'
                    || $p == '0701'
                    || $p == '0912'
                    ){
                        $data = 'airtel_300mb_eds_7days';
                    } else if($p == '0805'
                    || $p == '0905'
                    || $p == '0915'
                    || $p == '0807'
                    || $p == '0811'
                    || $p == '0705'
                    || $p == '0815'
                    ){
                        $data = 'glo_200mb_cg_14days';
                    } else if($p == '0909' 
                    || $p == '0908' 
                    || $p == '0818' 
                    || $p == '0809' 
                    || $p == '0817'
                    ){
                        $data = '9mobile_250mb_cg_30days';
                    } else {
                        echo json_encode(array(
                            "status" => "Error",
                            "message" => "Invalid Number",
                        ));
                        return;
                    }
                    
                    $body = "{
                        \"max_amount\": \"500\",
                        \"process_type\": \"instant\",
                        \"package_code\": \"$data\",
                        \"phone\": \"$ph\",
                        \"customer_reference\": \"$ref\"
                        }";

                    $head = array(
                        'Authorization: Bearer 437|ZSPDbGuLDi6ozYJCjHemIgpM50V9Vb6MxQ2bLh9X',
                        'Content-Type: application/json',
                    );

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://www.airtimenigeria.com/api/v1/data',
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

                    if ($r['status'] == 'success' && $r['message'] == 'Order Submitted Successfully') {

                        $phone = $r['details']['recipients'];
                        $amount = $r['details']['total_cost'];
                        $network = $r['details']['package'];
                        $flw_ref = $r['details']['reference'];
                        $ref2 = $r['details']['customer_reference'];

                        $sql = "INSERT INTO transactions_recharge(agent_id, use_case, phone, amount, network, ref, ref2, flw_ref) VALUES ('$agent_id', '$use_case', '$phone', '$amount', '$network', '$ref', '$ref2', '$flw_ref')";

                        if ($conn->query($sql)) {
                            echo json_encode(array(
                                "status" => "Ok",
                                "message" => 'Success',
                            ));

                        } else {
                            echo json_encode(array(
                                "status" => "Error",
                                "message" => "An Error Occured",
                            ));
                        }

                    } else {
                        echo json_encode(array(
                            "status" => "Error",
                            "message" => "Data Recharge Failed",
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
                    "message" => "Phone Number is Required!",
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