<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    if (!empty($data['agent_id'])) {
        $agent_id = '0';

        if (!empty($data['sub_id'])) {
            $subId = htmlentities(strip_tags($data['sub_id']), ENT_QUOTES, 'UTF-8');

            $sql0 = "SELECT * FROM agentsurvey WHERE agent_id = '$agent_id'";

            if ($conn->query($sql0)) {
                $res0 = mysqli_query($conn, $sql0);

                $chk0 = [];

                while ($re0 = mysqli_fetch_assoc($res0)) {
                    $chkId0 = $re0['survey_id'];
                    $chk0[] = $chkId0;
                }

                $ar0 = array_unique($chk0);

                $sql = "SELECT * FROM surveys1 WHERE subId = '$subId'";

                if ($conn->query($sql)) {
                    $res = mysqli_query($conn, $sql);

                    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
                    $t = count($data);

                    $ar = [];
                    $ar1 = [];

                    for ($i = 0; $i < $t; $i++) {
                        $ar = $data[$i]['id'];
                        $ar1[] = $ar;
                    }

                    $arr = array_diff($ar1, $ar0);

                    $tt = count($arr);

                    $cc = [];
                    $cc1 = [];
                    
                    $c = [];
                    
                    foreach ($arr as $key => $value) {
                     $xx = $value;
                     $c[] = $xx;
                    }

                    for ($i = 0; $i < $tt; $i++) {
                        $c1 = $c[$i];

                        $in = getIndex($c1, $data);

                        $cc['mi'] = $c1;
                        $cc['id'] = $data[$in]['id'];
                        $cc['survey_name'] = $data[$in]['survey_name'];
                        $cc['survey_description'] = $data[$in]['survey_description'];
                        $cc['json'] = $data[$in]['json'];
                        $cc['status'] = $data[$in]['status'];
                        $cc['categoryId'] = $data[$in]['categoryId'];
                        $cc['subId'] = $data[$in]['subId'];
                        $cc['temp'] = $data[$in]['temp'];
                        $cc['images'] = $data[$in]['images'];
                        $cc['user_id'] = $data[$in]['user_id'];
                        $cc['created_at'] = $data[$in]['created_at'];

                        $cc1[] = $cc;

                    }

                    if (!empty($data)) {
                        echo json_encode(array(
                            "status" => "Ok",
                            "message" => "success",
                            //"data1" => $ar1,
                           // "data0" => $ar0,
                            //"d" => $arr,
                           // "d1" => $c,
                            "data" => $cc1,
                        ));
                    } else {
                        echo json_encode(array(
                            "status" => "Error",
                            "message" => "No Survey Currently Available For Selected Category",
                            "data" => []
                        ));
                    }
                } else {
                    echo json_encode(array(
                        "status" => "Error",
                        "message" => "An Error Occured",
                    ));
                }
            }

        } else {
            echo json_encode(array(
                "status" => "Error",
                "message" => "Category Id is Required!",
            ));
        }

    } else {
        echo json_encode(array(
            "status" => "Error",
            "message" => "Agent Id is Required!",
        ));
    }

} else {
    echo json_encode(array(
        "status" => "Error",
        "message" => "Valid Input is Required!",
    ));
}

function getIndex($v, $d)
{
    $t = count($d);
    $ii = '';
    for ($i = 0; $i < $t; $i++) {
        $c = $d[$i]['id'];

        if ($c == $v) {
            $ii = $i;
            break;
        }
    }

    return $ii;

}
