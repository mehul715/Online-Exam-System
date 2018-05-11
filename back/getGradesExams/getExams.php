<?php



	$array = array();
	$studentlastname = "";
	$studentid="";

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");
    $response = file_get_contents('php://input');
    $array  = json_decode($response,true);

	$username = $array['username'];

	$transarray=array("username"=>$username);
	extract($transarray);
	//require 'getstudentlastname.php';

	//$identification = "s{$studentid}_{$studentlastname}";
	$queue = "SELECT DISTINCT Exam2.exam_id, Exam2.examname FROM studentGrades, Exam2 WHERE Exam2.exam_id = studentGrades.exam_id";

	$result = mysqli_query($connection,$queue);
	$sendarray = array();


	while($row=mysqli_fetch_assoc($result)){

			$examid 	= $row['exam_id'];
			$examname = $row['examname'];

			$sendarray[] = array("examid" => $examid, "examname" => $examname);
	}

	if(!$sendarray){
		$sendarray[] = array("response" => "no released exams");
	}

	echo json_encode($sendarray,true);

	mysqli_close($connection);

?>
