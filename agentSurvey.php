<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"),true);

if ($data != []) {

    $agent_id = htmlentities(strip_tags($data['agent_id']),ENT_QUOTES,'UTF-8');


    $agentsql = "SELECT * FROM agentsurvey WHERE agent_id = '$agent_id'";

    $querry = mysqli_query($conn,$agentsql);
    
    $ea = [];
    
    while ($re = mysqli_fetch_assoc($querry)) {

         
        $agentsurvey = $re['survey_id'];
        
        $ea[] = $agentsurvey;
        
        
        
    }
    
    
    $array1 = $ea;
    
    //  echo json_encode(["survey_id"=>$ea]);
    
    // shuffle($ea);
    
    //   foreach($ea as $value){
        
    //      $jrd = $value;

    //   }
      
      
      
      
      // get all the surveys 

    $thesurvey = "SELECT * FROM surveys WHERE type = 'app'";
    
    $theq = mysqli_query($conn,$thesurvey);
    
    $sam = [];
    while ($suf = mysqli_fetch_assoc($theq)) {

         $theid = $suf['id'];

         $sam[] = $theid;
        
    }
    
    
    $array2 = $sam;
    
    $main_array = array_diff($array2,$array1);
    
    // echo json_encode(["survey_id"=>$main_array]);
    
    
    // //shuffle

    shuffle($main_array);
    
    foreach($main_array as $value){
        
         $jd = $value;

        
    }
    
    if($jd == null){
       echo json_encode(["survey_id"=>0]); 
    } else{
       echo json_encode(["survey_id"=>$jd]); 
    }
    
    
    
    // if($jrd == $jd){
        
    //     echo json_encode(["message"=>"survey has been taken","survey_id"=>$jd]);
    // }else{
    //     echo json_encode(["message"=>"survey has not taken","survey_id"=>$jd]);
        
    // }

    

    
    
    // echo json_encode(["survey_id"=>$jrd]);

    
    // get all the surveys 

    // $thesurvey = "SELECT * FROM surveys WHERE id != '$agentsurvey'";

    // $theq = mysqli_query($conn,$thesurvey);
     
    // $sam = [];
    // while ($suf = mysqli_fetch_assoc($theq)) {

    //      $theid = $suf['id'];

    //      $sam[] = $theid;
        
    // }

    // //shuffle

    // shuffle($sam);
    
    // foreach($sam as $value){
        
    //      $jd = $value;

        
    // }

    // echo json_encode(["survey_id"=>$jd]);

    
}else{

    echo json_encode(["message"=>"agent_id,cannot be empty!"]);
}

?>