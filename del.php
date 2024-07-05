<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if (!empty($data['agent_id'])) {
        $agent_id = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO delete_request (agent_id) VALUES ('$agent_id')";

                        if ($conn->query($sql)) {
                            echo json_encode(array(
                                "status" => "Ok",
                                "message" => 'Success',
                                "code" => $conn->errno,
                            ));

                        } else {
                            echo json_encode(array(
                                "status" => "Error",
                                "message" => "An Error Occured",
                                "code" => $conn->errno,
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
        "message" => "Valid Input is Required!",
    ));
}

