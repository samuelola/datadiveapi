<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"),true);

if ($data != []) {

$id = htmlentities(strip_tags($data['agent_id']),ENT_QUOTES,'UTF-8');

$sql= "SELECT * FROM agentsurvey WHERE agent_id = $id";

if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);
            
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
        $sql1 = "SELECT * FROM agentsurvey WHERE agent_id = $id AND status = 'win' AND type = 'instant'";
        
        if ($conn->query($sql1)) {
            
            $res1 = mysqli_query($conn, $sql1);
            
            $data1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
            
            echo json_encode(array(
            "status" => "Ok",
            "completed" => count($data),
            "earnings" => count($data1) * 100
        ));
        } else {
            echo json_encode(array(
            "status" => "error",
            "message" => "An Error Occured"
        ));
        }
           
        
    }
} else {
    echo json_encode(array(
            "status" => "error",
            "message" => "Please Input Agent ID"
        ));
}

?>