<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if ($data['user_id'] != '') {
        $user_id = htmlentities(strip_tags($data['user_id']), ENT_QUOTES, 'UTF-8');

        if ($data['insight_id'] != '') {
            $insight_id = htmlentities(strip_tags($data['insight_id']), ENT_QUOTES, 'UTF-8');

            if ($data['survey_results'] != '') {
                    $survey_results = str_replace('\'', '\\\'', $data['survey_results']);     //htmlentities(($data['survey_results']), ENT_QUOTES, 'UTF-8');
                    
                    $cc = htmlentities(strip_tags($data['country']), ENT_QUOTES, 'UTF-8');
                    $ss = htmlentities(strip_tags($data['state']), ENT_QUOTES, 'UTF-8');
                    $db = htmlentities(strip_tags($data['dob']), ENT_QUOTES, 'UTF-8');
                    $gd = htmlentities(strip_tags($data['gender']), ENT_QUOTES, 'UTF-8');

                    $sql = "INSERT INTO insight_results (user_id, insight_id, json, country, state, dob, gender) VALUES ('$user_id', '$insight_id', '$survey_results', '$cc', '$ss', '$db', '$gd')";
                    if ($conn->query($sql)) {
                        echo json_encode(array(
                            "status" => "Ok",
                            "message" => 'Success',
                        ));

                    } else {
                        echo json_encode(array(
                            "status" => "Error",
                            "message" => "Survey Save Failed!!! Please Retry  " . $conn->errno,
                        ));
                    }

                } else {
                    echo json_encode(array(
                        "status" => "Error",
                        "message" => "Survey Response is Required",
                    ));
                }

        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Survey Identifier is Required",
            ));
        }

    } else {
        echo json_encode(array(
            "status" => "Error",
            "message" => "User Id is Required",
        ));
    }

} else {

    echo json_encode(["message" => "Error"]);
}
