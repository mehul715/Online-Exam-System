<?php
/*Take exam
===================================================================================

*/
#==============================================================================
	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
    #$connection = mysqli_connect("localhost","root","password", "mmd38");
	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response
#==============================================================================
/*
   $array[]=array("username"=>"mmd38");
   $array[]=array("examid"=>1,"examname"=>"easy","professor"=>"ryan");
	*/
	$arraysize= count($array);


#========================Exam Select Retrieve exam======================
									#e1_final_ryan
	$username	= $array[0]['username'];
	$exam_id 		= $array[1]['exam_id'];
	$examname = $array[1]['examname'];
	//$professor	= $array[1]['professor'];

	$sendarray[] = array("username" => $username);
	$sendarray[] = array("exam_id" => $exam_id, "examname" => $examname);

	//$identification = "e{$examid}_{$examname}_{$professor}";

//$num = 1;
	$queue = "SELECT ID, question, points from Question1 where ID in (select ID from Exam2 where examname = '$examname')";

	$result = mysqli_query($connection,$queue);
	//$num++;
	//echo $result;

	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$question    = $row['question'];
    $points      = $row['points'];



		$sendarray[] = array("questionid" => $questionid,
										   "question"    => $question,
                       "points"      => $points);


		}

		$finalarray = json_encode($sendarray);

		echo $finalarray;




?>
