<?php
include 'dbh.php';
include 'user_autheticate.php';
include 'utils.php';


if(isset($_POST)){
    $file = $_POST['json'];
    $filename = $_POST['filename'];//bgazei errors edw kapoies fores kai den fernei thn metablhth
    if($filename==null){$filename='errorharname';}
    $load = load_data_from_json($file,$filename, $user_id, $conn);
}

function load_data_from_json($jsonfile, $filename, $user_id, $conn){
    
    $i = create_upload($filename,$user_id, $jsonfile, $conn);
    foreach ($jsonfile['entries'] as $entry){
        //entry insert
        $id = uniqid();
        $serverIPAddress = $entry['serverIPAddress'];
        $startedDateTime = $entry['startedDateTime'];
        $wait = $entry['timings']['wait'];

        $serverGeoData = geolocateIP($serverIPAddress);

        $server_lat = $serverGeoData->lat;
        $server_lng = $serverGeoData->lon;

        $query = "INSERT INTO entry (id, upload_id, startedDateTime, wait, serverIPAddress, server_lat, server_lng) VALUES ('$id', '$i', '$startedDateTime', '$wait', '$serverIPAddress', '$server_lat', '$server_lng')";
        if(mysqli_query($conn, $query)){
            echo "ok";
        }else{
            echo "error $query." . mysqli_error($conn)."<br>";
        }
        
        //request insert
        $request = $entry['request'];
        $headers = json_encode($request['headers']);//bgazei errors polles fores sta headers files 
        if ($headers>= 1000){$headers=0;}
        $url = $request['url'];
        $parse_urll= parse_url($url);
        $domain = $parse_urll['host'];
        $method = $request['method'];
        $query1 = "INSERT INTO `request` (`entry_id`, `method`, `url`, `headers`) VALUES ('$id', '$method', '$domain', '$headers')";
        if(mysqli_query($conn, $query1)){
            echo "ok";
        }else{
            echo "error $query1." . mysqli_error($conn)."<br>";
        }

        //response insert
        $response = $entry['response'];
        $status = $response['status'];
        $statusText = $response['statusText'];
        $response_headers = json_encode($response['headers']);
        $query2 = "INSERT INTO `response` (`entry_id`, `status`, `statusText`, `headers`) VALUES ('$id', '$status', '$statusText', '1')";
        if(mysqli_query($conn, $query2)){
            echo "ok";
        }else{
            echo "error $query2." . mysqli_error($conn)."<br>";
        }
    }
}

function create_upload($filename, $user_id, $file, $conn){
    $uploadId = guidv4();
    //$userIP = getUserIpAddr();//h local ip tou server den pernaei
    $userIP='176.58.225.242';
    $userGeoData = geolocateIP($userIP);

    $user_isp = $userGeoData->isp;
    $user_lat = $userGeoData->lat;
    $user_lng = $userGeoData->lon;

    $query = "INSERT INTO `uploads`(`id`, `user_id`, `filename`, `user_isp`, `user_lat`, `user_lng`) VALUES ('$uploadId', '$user_id', '$filename', '$user_isp', '$user_lat', '$user_lng')";
    if(mysqli_query($conn, $query)){
        echo "ok";
    }else{
        echo "error $query." . mysqli_error($conn)."<br>";
}
    return $uploadId;
}
?>
