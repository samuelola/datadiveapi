<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$sql= "SELECT * FROM news ORDER BY publishedAt DESC";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    
    $data = [];
    
    while($row = mysqli_fetch_assoc($result)){
        
        $data[] = @$row['title'];
    }
    
    echo json_encode([
        
        "status" => "OK",
        "data" => $data
        
        ]);
    
}else{
    
   echo json_encode([
        
        "status" => "error",
        "message" => "An Error Occured"
        
        ]); 
}


// if ($conn->query($sql)) {
//         $res = mysqli_query($conn, $sql);
            
//       $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
//         echo json_encode(array(
//             "status" => "Ok",
//             "data" => $data
//         ));
//         } else {
//             echo json_encode(array(
//             "status" => "error",
//             "message" => "An Error Occured"
//         ));
//     }


?>