<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Methods: POST");
//include './database.php';
include_once("database.php");

$nm = "";

$url = 'https://tranxfercrypto.com/surveyapi/api/categories';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$res = curl_exec($ch);
curl_close($ch);
$data = json_decode($res, true);

$tt = count($data['data']);

for ($kk = 0; $kk < $tt; $kk++) {
    $GLOBALS['nm'] = strtolower($data['data'][$kk]['name']);
    $nm = strtolower($data['data'][$kk]['name']);

    $url0 = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyDvWzDELVr1ul2E-N334Ew5LSI8hjxnj7I&q=$nm+%23shorts&sp=EgIIAg%253D%253D&maxResults=4";
  //  AIzaSyDtkydXbF1WEFsOBkm92lZCRNVGwCwFTNE
    

    $ch0 = curl_init();
    curl_setopt($ch0, CURLOPT_URL, $url0);
    curl_setopt($ch0, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch0, CURLOPT_FOLLOWLOCATION, true);
    $res0 = curl_exec($ch0);
    curl_close($ch0);
    $data0 = json_decode($res0, true);

    $t = count($data0['items']);

    for ($k = 0; $k < $t; $k++) {
        $id = $data0['items'][$k]['id']['videoId'];

        $url1 = "https://www.googleapis.com/youtube/v3/videos?part=snippet,status,contentDetails,statistics&id=$id&key=AIzaSyDvWzDELVr1ul2E-N334Ew5LSI8hjxnj7I";

        $ch1 = curl_init();
        curl_setopt($ch1, CURLOPT_URL, $url1);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
        $res1 = curl_exec($ch1);
        curl_close($ch1);
        $data1 = json_decode($res1, true);

        $ca = $GLOBALS['nm'];
        $ti = str_replace("'", "''", $data1['items'][0]['snippet']['title']);
        $ds = str_replace("'", "''", $data1['items'][0]['snippet']['description']);
        
        if(!$data1['items'][0]['snippet']['thumbnails']['standard']){
            $im = $data1['items'][0]['snippet']['thumbnails']['high']['url'];
        } else {
           $im = $data1['items'][0]['snippet']['thumbnails']['standard']['url']; 
        }
        
        
        $rt = getRuntime($data1['items'][0]['contentDetails']['duration']);
        $rtt = $data1['items'][0]['contentDetails']['duration'];


        $sql = "INSERT INTO feeds(videoId, category, title, dsc, img, runtime) VALUES ('$id', '$ca', '$ti', '$ds', '$im', '$rt')";
        if ($conn->query($sql)) {
            echo "success<br><br>";
        } else {
            echo "failed $rtt<br><br>";
        }
    }

}

function getRuntime($s)
{
    $x = '';
    if (strpos($s, 'M') !== false) {
        $t = explode('M', $s);
        $u = $t[0];
        $u1 = $t[1];
        $v = str_replace('PT', '', $u);
        $v1 = str_replace('S', '', $u1);
        $w = $v * 60;
        if (strpos($u1, 'S') !== false) {
           $x = $w + $v1; 
        } else {
         $x = $w;   
        }
        
    } else {
        $t0 = str_replace('PT', '', $s);
        $x = str_replace('S', '', $t0);
    }

    return $x;
}


?>