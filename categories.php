<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$sql= "SELECT * FROM feed_categories WHERE status = '1' ORDER BY name";

if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);
            
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
           
        echo json_encode(array(
            "message" => "Ok",
            "data" => $data
        ));
        } else {
            echo json_encode(array(
            "message" => "error",
            "data" => ""
        ));
        }

?>