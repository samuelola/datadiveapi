<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include './database.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data != []) {

    $agent_id = htmlentities(strip_tags($data['agent_id']), ENT_QUOTES, 'UTF-8');
    $survey_id = htmlentities(strip_tags($data['survey_id']), ENT_QUOTES, 'UTF-8');
    $type = htmlentities(strip_tags($data['type']), ENT_QUOTES, 'UTF-8');
    
    if($type == 'Points'){
        $sql0 = "INSERT INTO agentsurvey(agent_id, survey_id, status, type) VALUES ('$agent_id', '$survey_id', 'points', 'points')";
                if ($conn->query($sql0)) {
                    echo json_encode(["message" => "Ok", "status" => 'Points']);
                } else {
                    echo json_encode(["message" => "Ok", "status" => 'win']);
                }} 
                else if($type == 'Instant') {
        $stat = ['win', 'lose'];
    shuffle($stat);

    foreach ($stat as $val) {
        $res = $val;
    }

    if ($res == 'win') {

        $ts = date("Y-m-d");

        $sql = "SELECT * FROM agentsurvey WHERE status = 'win' AND date(created_at) = '$ts'";

        if ($conn->query($sql)) {

            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            if ($count < 5) {

                $sql1 = "SELECT * FROM agentsurvey WHERE agent_id = '$agent_id' AND date(created_at) = '$ts' AND status = 'win'";

                if ($conn->query($sql1)) {

                    $result = mysqli_query($conn, $sql1);
                    $count1 = mysqli_num_rows($result);

                    if ($count1 < 1) {

                        $sql2 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'win')";
                        if ($conn->query($sql2)) {
                            echo json_encode(["message" => "Ok", "status" => 'win']);
                        } else {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        }

                    } else {
                        $sql3 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
                        if ($conn->query($sql3)) {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        } else {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        }

                    }

                } else {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                }

            } else {
                $sql4 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
                if ($conn->query($sql4)) {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                } else {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                }
            }

        } else {
            echo json_encode(["message" => "Error"]);
        }
    } else {
        $sql5 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
        if ($conn->query($sql5)) {
            echo json_encode(["message" => "Ok", "status" => 'lose']);
        } else {
            echo json_encode(["message" => "Ok", "status" => 'lose']);
        }
    }} 
    else {
        $stat = ['win', 'lose'];
    shuffle($stat);

    foreach ($stat as $val) {
        $res = $val;
    }

    if ($res == 'win') {

        $ts = date("Y-m-d");

        $sql = "SELECT * FROM agentsurvey WHERE status = 'win' AND date(created_at) = '$ts'";

        if ($conn->query($sql)) {

            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            if ($count < 5) {

                $sql1 = "SELECT * FROM agentsurvey WHERE agent_id = '$agent_id' AND date(created_at) = '$ts' AND status = 'win'";

                if ($conn->query($sql1)) {

                    $result = mysqli_query($conn, $sql1);
                    $count1 = mysqli_num_rows($result);

                    if ($count1 < 1) {

                        $sql2 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'win')";
                        if ($conn->query($sql2)) {
                            echo json_encode(["message" => "Ok", "status" => 'win']);
                        } else {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        }

                    } else {
                        $sql3 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
                        if ($conn->query($sql3)) {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        } else {
                            echo json_encode(["message" => "Ok", "status" => 'lose']);
                        }

                    }

                } else {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                }

            } else {
                $sql4 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
                if ($conn->query($sql4)) {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                } else {
                    echo json_encode(["message" => "Ok", "status" => 'lose']);
                }
            }

        } else {
            echo json_encode(["message" => "Error"]);
        }
    } else {
        $sql5 = "INSERT INTO agentsurvey(agent_id, survey_id, status) VALUES ('$agent_id', '$survey_id', 'lose')";
        if ($conn->query($sql5)) {
            echo json_encode(["message" => "Ok", "status" => 'lose']);
        } else {
            echo json_encode(["message" => "Ok", "status" => 'lose']);
        }
    }
    
    }

    

} else {

    echo json_encode(["message" => "Error"]);
}
