<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    $agentId = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO agent_rewards(agentId) VALUES ('$agentId')";
    

    if ($conn->query($sql)) {
        echo json_encode(array(
                "status" => "Ok",
                "message" => 'Agent Saved',
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
        "message" => "Agent Id is Required!",
    ));
}
