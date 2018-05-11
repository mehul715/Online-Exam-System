<?php

	$array = array();

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
	$response = file_get_contents('php://input');
   	$array  = json_decode($response,true);
	$sendarray = array();

  $username 	= $array['username'];
	$examid 		= $array['examid'];
	$username 	= 'mds39';
	$examid 		= '24';
	//$examname = $array['examname'];


	$sendarray[] = array("mds39" => $username);

$queue = "SELECT * FROM studentGrades, Exam2 WHERE studentGrades.exam_id = Exam2.exam_id AND studentGrades.exam_id='$examid'";
	$result = mysqli_query($connection,$queue);
	$row	= mysqli_fetch_assoc($result);
	$examname = $row['examname'];
	$grade = $row['grade'];

	$sendarray[] = array("examid" => $examid, "examname" => $examname, "grade" => $grade);
  //array_push($sendarray,array("examid" => $examid, "examname" => $examname, "grade" => $grade));

//SELECT DISTINCT Question1.ID,Question1.points, studentAnswers.functionName, studentAnswers.variableMatch, studentAnswers.answer,studentGrades.points_earned,Question1.question FROM submitResults2, Question1, studentAnswers, studentGrades WHERE studentAnswers.ID = Question1.ID AND studentGrades.exam_id = '22' AND studentAnswers.exam_id = '22'
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//$queue = "SELECT * FROM submitResults2, Question1, studentAnswers, studentGrades WHERE submitResults2.ID = Question1.ID AND studentAnswers.ID = Question1.ID AND  studentGrades.exam_id = '$examid' AND studentAnswers.exam_id = '$examid'";
$queue="SELECT DISTINCT studentAnswers.feedback,Question1.ID,Question1.points, studentAnswers.functionName, studentAnswers.variableMatch, studentAnswers.answer,studentGrades.points_earned,Question1.question FROM submitResults2, Question1, studentAnswers, studentGrades WHERE studentAnswers.ID = Question1.ID AND studentGrades.exam_id = $examid AND studentAnswers.exam_id = $examid";
	$result2 = mysqli_query($connection,$queue);
  //$i=0;
	while($row=mysqli_fetch_assoc($result2)){
    //$i++;
		$questionid	= $row['ID'];
		$question 		= $row['question'];
    $pointsgot  = $row['points_earned'];
    $pointstotal= $row['points'];
		$answer	= $row['answer'];
		$feedback 	= $row['feedback'];
    $functionName=$row['functionName'];
    $variableMatch=$row['variableMatch'];


    $combined=array();
    /*
		if($row['case_result'] == "success"){
			$caseshit		= $row['case_feedback'];
		}
		else
		{
				$casesmissed= $row['case_feedback'];
		}*/
    //Select submitResults2.case_result,submitResults2.case_feedback, submitResults2.casePoints from submitResults2 where submitResults2.ID = "220"
    $queue1="Select submitResults2.case_result,submitResults2.case_feedback, submitResults2.casePoints from submitResults2 where submitResults2.ID = '$questionid'";
     //array_push($combined,array("caseshit" =>$caseshit, "casesmissed"=>$casesmissed) );
     $result3 = mysqli_query($connection,$queue1);
		 while($row2 = mysqli_fetch_array($result3)){
			 //$i++;

				 //array_push($combined, array( $row2["caseshit"], $row2["casesmissed"]));
				 //echo $row2['case_result'];
				 //echo "<br>";
				 if($row2['case_result'] == "success" ){
					 $caseshit		= $row2['case_feedback'];
					 $casePoints = $row2['casePoints'];
					 //echo $caseshit;
					 ///echo "<br>";
					 array_push($combined, array("caseshit" =>$caseshit, "casePoints" =>$casePoints));
				 }
				 elseif($row2['case_result'] == "fail" )
				 {
						 $casesmissed= $row2['case_feedback'];

						 //echo $casesmissed;
						// echo "<br>";
						 array_push($combined, array("casesmissed"=>$casesmissed) );
						 //echo "<br>";
				 }


		 }
		$sendarray[] = array("questionid" => $questionid, "question" => $question,
		"answer" => $answer,"pointsgot"=>$pointsgot, "pointstotal" => $pointstotal,
		'variableMatch'=> $variableMatch,'functionName'=>$functionName,'feedback'=>$feedback, $combined);
	}

	echo json_encode($sendarray,true);


	mysqli_close($connection);

?>
