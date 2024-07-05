<?php

include_once "database.php";

$sql= "SELECT * FROM surveyresults1 WHERE user_id = '23'";

if ($conn->query($sql)) {
        $res = mysqli_query($conn, $sql);
            
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
        
        $t = count($data);
        
        $h = [];
        $d = [];
        
        for($i = 0; $i < $t; $i++){
            $j = $data[$i]['json'];
            $bb = $data[$i]['created_at'];
            $res = json_decode($j, true);
            $total = count($res);
            $ex = explode(' ', $bb);
            $tim = $ex[0];
            
            $newJ = rework($tim, $total, $res);
            
            $h[] = $j;
            $d[] = $newJ;
            
        }
        
      //  var_dump($d);
           
           
        echo json_encode(array(
            "status" => "Ok",
            "total" => $t,
            "h" => $h,
            "d" => $d,
          //  "data" => $data
        ));
        
        } else {
            echo json_encode(array(
            "status" => "error",
            "message" => "An Error Occured"
        ));
        }
        
      function rework($tim, $t, $j){
        $nj = [];
        for($i = 0; $i < $t; $i++){
            
            $a = array_keys($j)[$i];
            $b = $j[$a];
            $nj[] = $a.":".$b.",";
        }
        
        $nj[] = "Date Created:".$tim;
        
        return $nj;
          
      }  
        

?>

