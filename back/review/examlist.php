<?php



	$array = array();

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);


	$arraysize= count($array);

	$username=$array[1]['studentusername'];
	$transarray=array("username"=>$username);
	extract($transarray);



	$queue="SELECT DISTINCT examname, exam_id FROM Exam2 WHERE graded = 'yes'";

	$result=mysqli_query($connection,$queue);

	$rows = mysqli_num_rows($result);
	$array2[]=array("studentusername"=>$username);
	if($rows!=0){
		while($row=mysqli_fetch_assoc($result))
		{
			$examid		=$row['exam_id'];
			$examname	=$row['examname'];
			//$submitstatus=$row['released'];, "submitted"=>$submitstatus

			$array2[]=array("examid" => $examid, "examname" => $examname);


		}
	}
	else{
		$array2[] = array("response" => "none");
	}

	echo json_encode($array2,true);


	mysqli_close($connection);


?>
