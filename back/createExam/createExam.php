 <?php

	$array = array();

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

    $response = file_get_contents('php://input');

    $array  = json_decode($response,true);
	$arraysize= count($array);
	$result = mysqli_query($connection,"SELECT max(exam_id) FROM Exam2");

	$row= mysqli_fetch_assoc($result);
	$idmax=$row['max(exam_id)'];

   $examname = $array[0]['examname'];
   $points = $array[2]['points'];

      $idmax= $idmax+1;

			for($i = 1; $i<$arraysize; $i++){

				$questionid = $array[$i]['questionid'];
				$points     = $array[$i]['points'];

				$queue ="INSERT INTO Exam2 (exam_id, ID, examname) VALUES ('$idmax', '$questionid','$examname')";
				$result = mysqli_query($connection,$queue);
                if($queue) echo "submit success";
                else echo "fail";
      }

      for($i = 1; $i<$arraysize; $i++){

				$questionid = $array[$i]['questionid'];
				$points     = $array[$i]['points'];


				$queue ="UPDATE Question1 SET points='$points' WHERE ID ='$questionid' ";
				$result = mysqli_query($connection,$queue);
			}


	$response = array("response"=>"success");
	echo json_encode($response,true);

?>
