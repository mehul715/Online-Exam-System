<?php

$array = array();

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

$response = file_get_contents('php://input');
$array  = json_decode($response,true);
	$arraysize= count($array);
 print_r ($array);

    //$username = $array['username'];
    $exam_id = $array['exam_id'];
    //$grade = $array['grade'];
		$points =$array['points'];
		$ID=$array['ID'];


	$queue2 ="UPDATE studentAnswers SET totalCasePoints='$points' WHERE exam_id ='$exam_id' AND ID ='$ID' ";




	$result2 = mysqli_query($connection,$queue2);
//  $response = array("response"=>"success");
	echo json_encode($array);
	echo json_encode("came from back");

?>
