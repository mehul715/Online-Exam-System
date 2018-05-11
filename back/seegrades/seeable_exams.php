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



	$queue = "SELECT DISTINCT exam_id, examname, graded FROM Exam2";

	$result = mysqli_query($connection,$queue);
	$sendarray = array();

	while($row=mysqli_fetch_assoc($result)){

		//$available = $row['graded'];
		//if($available==="yes"){

			$examid 		= $row['exam_id'];
			$examname = $row['examname'];
			$grade = $row['graded'];


			$sendarray[] = array("examid" => $examid, "examname" => $examname, "grade" => $grade);
		
	}


	if(!$sendarray){
		$sendarray[] = array("response" => "no released exams");
	}

	echo json_encode($sendarray,true);

	mysqli_close($connection);

?>
