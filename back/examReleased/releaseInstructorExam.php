<?php

	$array=array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");


    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);
	extract($data);




	$result = mysqli_query($connection,"SELECT DISTINCT examname FROM Exam2 ");

	$rows = mysqli_num_rows($result);

	for($i = 0; $i < $rows; $i++)
	{
		$row = mysqli_fetch_assoc($result);
		$exam_id = $row['exam_id'];
		$examname = $row['examname'];
		$array[] =  array("exam_id"=>$exam_id, "examname" => $examname);

	}
	//echo $array;
	$code = json_encode($array,true);
	mysqli_close($connection);
	echo $code;


?>
