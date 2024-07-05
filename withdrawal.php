<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include './database.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if ($data['agent_id'] != '') {
        $agentId = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

        if ($data['amount'] != '') {
            $am = htmlentities(strip_tags($data['amount']), ENT_QUOTES, 'UTF-8');

            if ($data['type'] != '') {
                $type = htmlentities(strip_tags($data['type']), ENT_QUOTES, 'UTF-8');

                if ($type == 'points' || $type == 'referrals') {

                    if ($type == 'points') {
                        $sql = "UPDATE agent_rewards SET points = points - '$am' WHERE agentId = '$agentId'";
                    } else if ($type == 'referrals') {
                        $sql = "UPDATE agent_rewards SET referrals_points = referrals_points - '$am' WHERE agentId = '$agentId'";
                    }

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
                        "message" => "Invalid Type Submitted",
                    ));
                }

            } else {
                echo json_encode(array(
                    "status" => "Error",
                    "message" => "Type is Required",
                ));
            }

        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Amount is Required",
            ));
        }

    } else {
        echo json_encode(array(
            "status" => "Error",
            "message" => "Agent Id is Required",
        ));
    }

} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "All fields are Required!",
    ));
}
} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "Access Denied",
    ));
}
