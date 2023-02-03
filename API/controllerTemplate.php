<?php
    $data_key ="";
    if(isset($_POST["data_key"])){
        $data_key = $_POST["data_key"];
    }
    //connect to resource
    $url = "https://www.waitsuentkd.com/sparring/API/resource.php";

    $ch = curl_init($url);
    //curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json')
    );

    // get json and convert to array
    $result = curl_exec($ch);
    // echo $result;
    curl_close($ch);
    //connect to resource
    
    $data = json_decode($result, true);
    //echo count($data);
    // get json and convert to array
    
    //select and return json
    $response = $data['$data_key'];
    echo json_encode($response);
    //echo count($athletes);
    //select and return json
    
?>