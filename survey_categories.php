<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
include './database.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  $sql = "SELECT * FROM survey_categories WHERE status = '1' ORDER BY name";

    if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);

        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);

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
            "message" => "Access Denied",
        ));
    } 



?>