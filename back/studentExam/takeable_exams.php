<?php


	$link = mysql_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	if($link == false){
		die('Could not connect to SQL');
	}
	mysql_select_db('mds39');
	$query = "SELECT DISTINCT exam_id, examname FROM Exam2 ";
	$result = mysql_query($query);

	$returnArray = array();

	while($row = mysql_fetch_array($result)){
		$returnArray[] = array('exam_id' => $row['exam_id'], 'examname' => $row['examname']);
	}




	$json = json_encode($returnArray);
	echo $json;
	mysql_close($link);

/*
	$array = array();

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================


	$examid = $array['exam_id'];



	$arraysize= count($array);


	$username=$array['username'];
	$transarray=array("username"=>$username);
	extract($transarray);




	$queue="SELECT DISTINCT exam_id, examname FROM Exam2  ";

	$result=mysqli_query($connection,$queue);

	$rows = mysqli_num_rows($result);

	if($rows!=0){

		//$array2[] = array("response" => "yes");
		while($row=mysqli_fetch_assoc($result))
		{
			$exam_id	= $row['exam_id'];
			$examname	= $row['examname'];
			//echo $examname;
			//$examname = 'trytrytry';
			//$professor	=$row['professor'];

			$array2[]=array("exam_id" => $exam_id, "examname" => $examname);


		}
	}
	else{
		$array2[] = array("response" => "none");
	}



	echo json_encode($array2);


	mysqli_close($connection);

*/
?>
