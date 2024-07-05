<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';


$id = $_GET["id"];

if ($id != '') {
    

$sql= "SELECT * FROM surveys1 WHERE subId = '$id'";

if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);
            
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
           
        echo json_encode(array(
            "status" => "Ok",
            "data" => $data
        ));
        } else {
            echo json_encode(array(
            "status" => "error",
            "message" => "An Error Occured"
        ));
        }
    
} else {
    echo json_encode(array(
            "status" => "error",
            "data" => "Please Input Feeds Category"
        ));
}


?>