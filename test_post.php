<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

                    $userName = htmlentities(strip_tags($data['user']), ENT_QUOTES, 'UTF-8');
                    $fName = htmlentities(strip_tags($data['fname']), ENT_QUOTES, 'UTF-8');
                    $lName = htmlentities(strip_tags($data['lname']), ENT_QUOTES, 'UTF-8');

                    $sql = "INSERT INTO test_post (userName, lName, fName) VALUES ('$userName', '$lName', '$fName')";
                    if ($conn->query($sql)) {
                        echo json_encode(array(
                            "status" => "Ok",
                            "message" => 'Success',
                        ));

                    } else {
                        echo json_encode(array(
                            "status" => "Error",
                            "message" => "Error" . $conn->errno,
                        ));
                    }   

} else {

    echo json_encode(["message" => "Error"]);
}
