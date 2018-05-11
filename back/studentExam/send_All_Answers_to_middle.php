<?php



		$connection =  mysql_connect("sql2.njit.edu","mds39","shreekrishna");
		mysql_select_db('mds39');

	$response = file_get_contents('php://input');
	 $array  = json_decode($response,true);
  $id =	$array['exam_id'];
	

		$query = "SELECT * FROM studentAnswers WHERE exam_id = $id";

		$result = mysql_query($query);
		$array1 = array();

		while($row = mysql_fetch_array($result)){
			$array1[] = array('ans_id' => $row['ans_id'], 'questionID' =>
			$row['ID'], 'answer' => $row['answer'], 'username' => $row['username']);
		}

		$json = json_encode($array1);
		echo $json;

		mysql_close($connection);


?>
