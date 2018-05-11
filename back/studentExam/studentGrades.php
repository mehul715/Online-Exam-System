<?php

	$array = array();

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);
  	$arraysize= count($array);
   print_r ($array);

    $username = $array['username'];
    $exam_id = $array['exam_id'];
    $grade = $array['grade'];
		$points =$array['points'];
		$totalPoints=$array['totalPoints'];
		//$ID=$array['ID'];

	$queue = "INSERT INTO studentGrades (username,exam_id, grade, totalPoints) VALUES  ('$username', '$exam_id', '$grade','$totalPoints')";
	$queue1 ="UPDATE Exam2 SET graded='yes' WHERE exam_id ='$exam_id' ";
	//$queue2 ="UPDATE Question1 SET points=$points WHERE exam_id ='$exam_id' AND ID ='$ID' ";

	$result = mysqli_query($connection,$queue);
  if(queue){
    echo "it worked";
  }


	$result1 = mysqli_query($connection,$queue1);
	//$result2 = mysqli_query($connection,$queue2);
  $response = array("response"=>"success");
	echo json_encode($totalPoints);

?>
