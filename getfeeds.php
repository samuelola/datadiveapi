<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

//$data = json_decode(file_get_contents("php://input"),true);

$ty = $_GET["category"];

if ($ty != '') {
    
   // $ty = htmlentities(strip_tags($data['category']),ENT_QUOTES,'UTF-8');
    
$sql= "SELECT * FROM feeds WHERE category = '$ty'";

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