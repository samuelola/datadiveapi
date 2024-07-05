<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    $agentId = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

    $sql = "SELECT * FROM agent_rewards WHERE agentId = '$agentId'";

    if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);

        $data = mysqli_fetch_assoc($res);

        if (!empty($data)) {
            echo json_encode(array(
                "status" => "Ok",
                "message" => "success",
                "data" => $data,
            ));
        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Agent Not Found",
            ));
        }

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
