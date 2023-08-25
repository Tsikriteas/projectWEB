<?php
    include("dbh.php");


    if (isset($_GET['query']) && $_GET['query'] === 'timings') {

            $resp = json_encode([
                'status' => 200,
                'data' => [
                    'timings' => getTimings() 
                ]
            ]);
            echo $resp;
    }

    //query gia chart data
    function getTimings() {
        $query = "SELECT e.startedDateTime, e.wait, up.user_isp, req.method, JSON_EXTRACT(res.headers, '$.content-type') as content_type "
                ."FROM `entry` as e INNER JOIN response as res ON e.id = res.entry_id INNER JOIN request as req ON e.id = req.entry_id "
                ."INNER JOIN uploads as up ON up.id = e.upload_id";
        
        global $conn;
        $rows = [];
        if ($result = $conn->query($query)) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->free();
        }
        return $rows;
    }
    ?>