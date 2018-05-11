<?php

	$array = array();


	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	$response = file_get_contents('php://input');
   	$array  = json_decode($response,true);
	$sendarray = array();


	$username 	= $array['username'];
	$examid 		= $array['examid'];
	$examname = $array['examname'];
	//$professor	=	$array['professor'];

	$sendarray[] = array("username" => $username);





	$transarray=array("username"=>$username);
	extract($transarray);

	$queue = "SELECT * FROM studentGrades,Exam2 WHERE studentGrades.exam_id='$examid' AND studentGrades.exam_id = Exam2.exam_id";

	$result = mysqli_query($connection,$queue);
	$row	= mysqli_fetch_assoc($result);

	$grade = $row['grade'];

	$sendarray[] = array("examid" => $examid, "examname" => $examname, "grade" => $grade);



	//$identification2 = "sub{$examid}_{$examname}_{$studentlastname}_{$professor}";

	$queue = "SELECT * FROM studentAnswers, Question1 WHERE studentAnswers.ID = Question1.ID";

	$result2 = mysqli_query($connection,$queue);

	while($row=mysqli_fetch_assoc($result2)){

		$questionid	= $row['ID'];
		$question 		= $row['question'];
		//$caseshit		= $row['caseshit'];
		//$casesmissed= $row['casesmissed'];
    //$pointsgot  = $row['pointsgot'];
    //$pointstotal= $row['pointstotal'];
		$answer	= $row['answer'];
		//$feedback 	= $row['feedback'];

		$sendarray[] = array("questionid" => $questionid, "question" => $question,"answer" => $answer);
	}

	echo json_encode($sendarray,true);


	mysqli_close($connection);

?>
