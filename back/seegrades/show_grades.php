<?php

	$array = array();

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	$response = file_get_contents('php://input');
   	$array  = json_decode($response,true);
	$sendarray = array();

  $username 	= $array['username'];
	$examid 		= $array['examid'];



	$sendarray[] = array("mds39" => $username);

$queue = "SELECT * FROM studentGrades, Exam2 WHERE studentGrades.exam_id = Exam2.exam_id AND studentGrades.exam_id='$examid'";
	$result = mysqli_query($connection,$queue);
	$row	= mysqli_fetch_assoc($result);
	$examname = $row['examname'];
	$grade = $row['grade'];
		$newgrade = $row['newGrade'];

	$sendarray[] = array("examid" => $examid, "examname" => $examname, "grade" => $grade,"newGrade"=>$newgrade);

$queue="SELECT DISTINCT studentAnswers.totalCasePoints,Question1.ID,Question1.points, studentAnswers.functionName, studentAnswers.variableMatch, studentAnswers.answer,Question1.question, studentAnswers.feedback FROM submitResults2, Question1, studentAnswers, studentGrades WHERE studentAnswers.ID = Question1.ID AND studentGrades.exam_id = '$examid' AND studentAnswers.exam_id = '$examid'";
	$result2 = mysqli_query($connection,$queue);

	while($row=mysqli_fetch_assoc($result2)){

		$questionid	= $row['ID'];
		$question 		= $row['question'];
    $pointsgot  = $row['totalCasePoints'];
    $pointstotal= $row['points'];
		$answer	= $row['answer'];
		$feedback 	= $row['feedback'];
    $functionName=$row['functionName'];
    $variableMatch=$row['variableMatch'];


    $combined=array();


    $queue1="SELECT submitResults2.case_result,submitResults2.case_feedback, submitResults2.casePoints from submitResults2 where submitResults2.ID = '$questionid'";

     $result3 = mysqli_query($connection,$queue1);
		 while($row2 = mysqli_fetch_array($result3)){

				 if($row2['case_result'] == "success" ){
					 $caseshit		= $row2['case_feedback'];
					 $casePoints = $row2['casePoints'];

					 array_push($combined, array("caseshit" =>$caseshit, "casePoints" =>$casePoints));
				 }
				 elseif($row2['case_result'] == "fail" )
				 {
						 $casesmissed= $row2['case_feedback'];
						 array_push($combined, array("casesmissed"=>$casesmissed) );

				 }


		 }
		$sendarray[] = array("questionid" => $questionid, "question" => $question,
		"answer" => $answer,"totalCasePoints"=>$pointsgot, "pointstotal" => $pointstotal,
		'variableMatch'=> $variableMatch,'functionName'=>$functionName,'feedback'=>$feedback, $combined);
	}

	echo json_encode($sendarray,true);


	mysqli_close($connection);

?>
