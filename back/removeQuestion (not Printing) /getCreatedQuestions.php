<?php

	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  //$array  = json_decode($response,true);                       #Get the response

	$queue="SELECT * FROM Question1";
	$result=mysqli_query($connection,$queue);
	$numofrows=mysqli_num_rows($result);

	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$question = $row['question'];
		//$category = $row['category'];
		//$level = $row['level'];
		//$cases = $row['cases'];



		$array[] = array("id" => $questionid,
								  "question" => $question);
								  //"category" => $category,
								  //"level" 	=> $level,
								  //"cases"	=> $cases);
	}
	   mysqli_close($connection);
	  echo json_encode($array);

?>
