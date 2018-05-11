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

	$queue = "SELECT * FROM studentGrades WHERE exam_id='$examid' ";

	$result = mysqli_query($connection,$queue);
	$row	= mysqli_fetch_assoc($result);

	$grade = $row['grade'];

	$sendarray[] = array("examid" => $examid, "examname" => $examname,"grade" => $grade);

	$queue = "SELECT * FROM Question1 WHERE ID = (SELECT ID FROM Exam2 WHERE exam_id='$examid')";

	//$queue = "SELECT Question1.ID, Question1.question, Question1.points, studentAnswers.answer FROM Question1,studentAnswers WHERE Question1.ID = (SELECT ID FROM Exam2 WHERE exam_id='$examid')";
	$result = mysqli_query($connection,$queue);
	if($result){
	while($row=mysqli_fetch_assoc($result)){

		$questionid	= $row['ID'];
		$question 		= $row['question'];
		$points	= $row['points'];
		//$answer = $row['answer'];


		$sendarray[] = array("questionid" => $questionid, "question" => $question, "points"=> $points, "answer"=>$answer);
	}
	}
 else{
   $sendarray[]=array("response"=>"Never submitted");
 }
	echo json_encode($sendarray,true);


	mysqli_close($connection);

?>
