<?php
include 'dbh.php';
include 'user_autheticate.php';


if (isset($_GET['query']) && $_GET['query'] === 'heatmap') {

   $query = "SELECT server_lat as lat, server_lng as lng, count(*) as count FROM `entry` "
            ."INNER JOIN uploads as u ON upload_id = u.id WHERE server_lat is not null and server_lng is not null "
            ."AND user_id = '$user_id' group by server_lat, server_lng";
    $points = [];
    $max = -1;

    if (($result = $conn->query($query)) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $points[]= $row;
            if ($row['count'] > $max) {
                $max = $row['count'];
            }
        }        
        $result->free();
    }
    $resp = json_encode([
        'max' => $max,
        'points' => $points 
    ]);
    echo $resp;

}else if (isset($_GET['query']) && $_GET['query'] === 'stats') {
 
    $query = "SELECT MAX(created_at) last_upload, COUNT(e.id) as entries FROM `uploads` u INNER JOIN entry e ON e.upload_id = u.id WHERE user_id = '$user_id'";

    if (($result = $conn->query($query)) && $result->num_rows > 0) {//thellei ftiaksimo 
        while ($row = $result->fetch_assoc()) {
            $entries= $row['entries'];
            $last_upload[]=$row['last_upload'];
        }        
        $result->free();
    }

    $data = json_encode([
        'entries' => $entries,
        'last_upload' => $last_upload 
    ]);
    echo $data;

}

?>