<?php

	$response = file_get_contents('php://input');
	$send = json_decode($response,true);



	$field= json_encode($send,true);


$url="https://web.njit.edu/~mmp39/CS490/master/middle/createQuestion/createQuestion.php";

$curl = curl_init();

  
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $field
  ));
$resp = curl_exec($curl);
$response = json_decode($resp,true);


echo json_encode($response,true);

?> 