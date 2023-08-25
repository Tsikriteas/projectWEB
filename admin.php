<?php
include 'dbh.php';

//data for admin map 
if (isset($_GET['query']) && $_GET['query'] === 'map') {
            
    $query = "SELECT COUNT(*) as cnt, user_id, user_lat, user_lng, server_lat, server_lng FROM `uploads` as up "
    ."INNER JOIN `entry` as e ON e.upload_id = up.id GROUP BY user_lat, user_lng, server_lat, server_lng";

    if (($result = $conn->query($query)) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $marks[]= $row;
        }        
        $result->free();
    }
    $data = json_encode([$marks]);
    echo $data;       
}

if (isset($_GET['query']) && $_GET['query'] === 'statssss') {

    $resp = json_encode([
            'users_count' => users_count(),
            'entriesCount_requestType' => count(entriesCount_requestType()),
            'entriesCount_responseStatus' => count(entriesCount_responseStatus()),
            'unique_Domains' => unique_Domains(),
            'tUniqueUserISPs' => tUniqueUserISPs()       
    ]);
    echo $resp;
}

function users_count() {
    $query = "SELECT COUNT(*) as cnt FROM `users`";
    $results = GetResults($query);
    return count($results) === 1 ? $results[0]['cnt'] : 0;
}

function entriesCount_requestType() {
    $query = "SELECT r.method as tag, count(*) as value FROM `request` as r INNER JOIN `entry` as e ON r.entry_id = e.id GROUP BY r.method";
    return GetResults($query);
}

function entriesCount_responseStatus() {
    $query = "SELECT r.status as tag, count(*) as value FROM `response` as r INNER JOIN `entry` as e ON r.entry_id = e.id GROUP BY r.status";
    return GetResults($query);
}

function unique_Domains() {
    $query = "SELECT COUNT(DISTINCT url) as cnt FROM `request`";
    $results = GetResults($query);
    return count($results) === 1 ? $results[0]['cnt'] : 0;
}
function tUniqueUserISPs() {
    $query = "SELECT COUNT(DISTINCT user_isp) as cnt FROM `uploads`";
    $results = GetResults($query);
    return count($results) === 1 ? $results[0]['cnt'] : 0;
}

// fetch query results
function GetResults($query) {
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