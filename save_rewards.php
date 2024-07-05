<?php

ini_set('display_errors', 'On'); 
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';


$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if ($data['agent_id'] != '') {
        $agentId = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

        if ($data['type'] != '') {
            $type = htmlentities(strip_tags($data['type']), ENT_QUOTES, 'UTF-8');

            if($type == 'points' || $type == 'instant' || $type == 'referrals'){
                if ($type == 'points') {
                    $sql = "UPDATE agent_rewards SET points = points + 10, points_all = points_all + 10, completed_surveys = completed_surveys + 1 WHERE agentId = '$agentId'";
                } else if ($type == 'instant') {
                    $sql = "UPDATE agent_rewards SET earnings_all = earnings_all + 100, completed_surveys = completed_surveys + 1 WHERE agentId = '$agentId'";
                } else if ($type == 'referrals') {
                    $sql = "UPDATE agent_rewards SET referrals = referrals + 1, referrals_points = referrals_points + 50, referrals_points_all = referrals_points_all + 50 WHERE agentId = '$agentId'";
                }
            
                
                if ($conn->query($sql)) {
                    echo json_encode(array(
                        "status" => 'Ok',
                        "count" => $conn->affected_rows,
                        "message" => 'Agent Rewarded!!!'
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
            "message" => "Agent Id is Required",
        ));
    }

} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "All fields are Required!",
    ));
}
