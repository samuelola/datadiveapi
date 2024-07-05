<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"),true);

if ($data != []) {

$id = htmlentities(strip_tags($data['survey_id']),ENT_QUOTES,'UTF-8');

$sql= "SELECT * FROM surveyresults WHERE survey_id = '$id'";

$result =  mysqli_query($conn,$sql);
 
$count = mysqli_num_rows($result);


if($count){
    $s = date("Y-m-d");
    
    if($count <= 20){
        echo json_encode(["message"=>"True","count"=>$count]);
    }
    
}
else{
    echo json_encode(["message"=>"False","count"=>$count]);
}
    
}else{
    echo json_encode(["message"=>"survey_id is empty!"]);
}



?>