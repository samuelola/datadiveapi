<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$sql= "SELECT json FROM surveyresults";

$result =  mysqli_query($conn,$sql);
 
$count = mysqli_num_rows($result);

if($count){

    $allsurveys = [];

    while($row = mysqli_fetch_assoc($result)){

        array_push($allsurveys,$row); 
    }
   
    $the_result['users'] = $allsurveys;

    echo json_encode($the_result);
}
else{
    echo json_encode(["message"=>"no Survey result  found","status"=>"error"]);
}

?>