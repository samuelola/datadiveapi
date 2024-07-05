<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$sql= "SELECT * FROM users";

$result =  mysqli_query($conn,$sql);
 
$count = mysqli_num_rows($result);


if($count){

    $users = [];

    while($row = mysqli_fetch_assoc($result)){

        array_push($users,$row); 
    }
   
    $the_result['users'] = $users;

    echo json_encode($the_result);
}
else{
    echo json_encode(["message"=>"no users found","status"=>"error"]);
}

?>