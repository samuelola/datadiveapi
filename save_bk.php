<?php

ini_set('display_errors', 'On'); 
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';


$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if ($data['agent_id'] != '') {
        $agentId = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');

        if ($data['bookmarks'] != '') {
           // $bookmarks = htmlentities(strip_tags($data['bookmarks']), ENT_QUOTES, 'UTF-8');
            $bookmarks = $data['bookmarks'];
            $sql = "UPDATE agent_rewards SET bk = '$bookmarks' WHERE agentId = '$agentId'";
 
                if ($conn->query($sql)) {
                    $c = $conn->affected_rows;
                    
                    if($c == 1){
                      echo json_encode(array(
                        "status" => 'Ok',
                        "message" => 'Bookmark Saved Successfully'
                    ));  
                    } else {
                       echo json_encode(array(
                        "status" => "Error",
                        "message" => "Bookmark Save Failed $c",
                    )); 
                    }
                    
                    
                } else {
                    echo json_encode(array(
                        "status" => "Error",
                        "message" => "Error Occured ".$conn->errno,
                    ));
                }

            
        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Bookmark is Required",
            ));
        }

    } else {
        echo json_encode(array(
            "status" => "Error",
            "message" => "Agent Id is Required",
        ));
    }

} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "All fields are Required!",
    ));
}
