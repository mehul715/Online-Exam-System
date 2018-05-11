<?php




	$array = array();

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);
  	$arraysize= count($array);
   print_r ($array);
        //$body = json_decode(file_get_contents('php://input'), true);

	$username = $array['username'];
  $testCaseID = $array['testCaseID'];
  $ans_id = $array['ans_id'];
  $case_result = $array['result'];
 	$exam_id = $array['exam_id'];
  $ID = $array['question_id'];
	$casePoints=$array['casePoints'];
	$case_feedback=$array['case_feedback'];
	$functionName=$array['functionName'];
	$variableMatch=$array['variableMatch'];
	//'functionName'=>$functionName
	//'casePoints'=>$casePoints


  //$queue ="INSERT INTO submitResults2 (username, case_id, ans_id, case_result,ID,exam_id) VALUES ('$username','$testCaseID','$ans_id','$case_result', '$ID','$exam_id')";
	$queue ="INSERT INTO submitResults2 (username, case_id, ans_id, case_result,ID,exam_id,casePoints, case_feedback) VALUES ('$username','$testCaseID','$ans_id','$case_result','$ID','$exam_id','$casePoints','$case_feedback')";
	$queue1 ="UPDATE studentAnswers SET functionName='$functionName',variableMatch='$variableMatch' WHERE exam_id ='$exam_id' AND ID='$ID'";


	$result = mysqli_query($connection,$queue);
  if(queue){
    echo "it worked";
  }
	$result1 = mysqli_query($connection,$queue1);

  $response = array("response"=>"success");
	echo json_encode($variableMatch);

?>
