<?php
	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);

  echo json_decode($response,true);
	$questionid=$array['questionid'];
	echo $questionid;

	$queue="SELECT * FROM Question1 WHERE ID='$questionid'";
	$result=mysqli_query($connection,$queue);

	$row=mysqli_fetch_assoc($result);
	$question=$row['question'];

		$queue2="DELETE FROM Question1 WHERE question='$question'";
		$result2=mysqli_query($connection,$queue2);


	   mysqli_close($connection);

	   $array=array("response"=>"deleted");

	   echo json_encode($array,true);

?>
