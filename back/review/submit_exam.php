<?php



	$array = array();

	$questionid=1;
	$question   ="";
	$caseshit		="";
	$casesmissed ="";
	$submitted  ="";
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);                       #Get the response

	$arraysize= count($array);
	$finals=json_encode($array,true);


	$username = $array[0]['studentusername'];
	$examid	   = $array[0]['examid'];
	$examname= $array[0]['examname'];
	$newgrade = $array[1]['newgrade'];

	$examname = strtolower($examname);

#=================================================================
#Make Table
	$transarray=array("username"=>$username);
	extract($transarray);
	#===================================================================

	$queue = "SELECT * FROM studentAnswers";

	$result1 = mysqli_query($connection,$queue);
	$i=1;

#===================================================================
	while($row=mysqli_fetch_assoc($result1)){

		$questionid = $array[$i]['questionid'];
		$feedback = $array[$i]['feedback'];
		$changedPoints=$array[$i]['changedPoints'];
		$newpoints = $newgrade;

		$i++;
		#===============If they updating the points=========================
		if($newpoints!=""){
				$newpoints = (int)$newpoints;
				$queue = "UPDATE studentGrades SET newGrade ='$newgrade' WHERE exam_id = '$examid'";
				$result = mysqli_query($connection,$queue);
		}


// changedPoints='$changedPoints'
//$queue1 = "UPDATE studentAnswers SET changedPoints='$changedPoints' WHERE ID='$questionid' AND exam_id = '$examid' ";
		$queue = "UPDATE studentAnswers SET feedback='$feedback', changedPoints='$changedPoints' WHERE ID='$questionid' AND exam_id = '$examid' ";
		//$result = mysqli_query($connection,$queue1);
		$result = mysqli_query($connection,$queue);

	}

#===================================================================
#Update data in student's database
	/*$queue = "SELECT * FROM $identification";
	$result = mysqli_query($connection,$queue);

	$points=0;
	$total=0;

	while($row=mysqli_fetch_assoc($result)){
		$pointsgot = $row['pointsgot'];
		$totalamount	= $row['pointstotal'];

		$points = $points + $pointsgot;
		$total   = $total + $totalamount;

	}

	$newgrade = $points / $total;

	*/

	//$score = number_format((float)($newgrade),2,'.','');
	//$score = $score*100;
	//$identification2="s{$studentid}_{$studentlastname}";

	//echo $score;
	//$queue ="UPDATE studentGrades SET grade='$score' WHERE ID='$examid'";
	$result = mysqli_query($connection,$queue);

	$sendarray = array("response"=>"submitted");
	echo json_encode($response,true);
?>
