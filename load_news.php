<?php
ini_set("display_errors", 1);

include_once "database.php";

$sql = "TRUNCATE TABLE news";

if ($conn->query($sql)) {
    $url = 'https://newsapi.org/v2/top-headlines?country=ng&sortBy=publishedAt&pageSize=50&apiKey=41d6043f2bbc4a9e8359583a718c6f8c';

    $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $res = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($res, true);

    $t = count($data['articles']);

    for ($k = 0; $k < $t; $k++) {

        $nm = $data['articles'][$k]['author'];
       // $nm = $data['articles'][$k]['source']['name'];

        if ($nm == 'Channels Television'
            || $nm == 'P.M. News'
            || $nm == 'Saharareporters.com'
            || $nm == 'THISDAY Newspapers'
            || $nm == 'Daily Post Nigeria'
            || $nm == 'Nyscinfo.com'
            || $nm == 'Tribuneonlineng.com'
            || $nm == 'Guardian Nigeria'
            || $nm == 'The Nation Newspaper'
            || $nm == 'The Punch'
            || $nm == 'Thecable.ng'
            || $nm == 'Naijaknowhow.net'
            || $nm == 'Leadership News'
            || $nm == 'Premium Times') {

            $ur = $data['articles'][$k]['url'];
            $ti = str_replace("'", "''", $data['articles'][$k]['title']);
            $ds = str_replace("'", "''", $data['articles'][$k]['description']);
            if($data['articles'][$k]['urlToImage']!= null){
               $im = $data['articles'][$k]['urlToImage']; 
            } else {
               $im = 'https://tranxfercrypto.com/surveyapi/api/z.png'; 
            }
            
            $p1 = str_replace("T", " ", $data['articles'][$k]['publishedAt']);
            $pu = str_replace("Z", "", $p1);

            $sql = "INSERT INTO news(url, title, dsc, img, publishedAt, source) VALUES ('$ur', '$ti', '$ds', '$im', '$pu', '$nm')";

            if ($conn->query($sql)) {
                echo "success<br><br>";
            } else {
                echo "failed<br><br>";
            }
        } else {
            echo "false" . "<br><br>";
        }
    }
} else {
    echo "Process Failed<br><br>" . $conn->errno;
}
