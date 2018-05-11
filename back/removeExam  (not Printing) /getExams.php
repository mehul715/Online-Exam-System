<?php

	$array=array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");


    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);


    $username = $decoder['username'];


	$data=['username'=>$username];
	extract($data);
	require 'getteacherlastname.php';


	$identification ="t{$id}_{$lastname}";


	$result = mysqli_query($connection,"SELECT * FROM $identification");

	$rows = mysqli_num_rows($result);

	if($rows){
	for($i = 0; $i < $rows; $i++)
		{
		$row = mysqli_fetch_assoc($result);
		$examid = $row['ID'];
		$examname = $row['examname'];
		$release		=$row['releasable'];

		$array[] =  array("examid" => $examid, "examname" => $examname,"release"=>$release);

		}
	}
	else{
		$array[]=array("response"=>"no exams");
	}
	//echo $array;
	$code = json_encode($array,true);
	mysqli_close($connection);
	echo $code;




?>
