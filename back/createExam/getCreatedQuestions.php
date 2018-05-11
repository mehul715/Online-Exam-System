<?php
	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

	$queue="SELECT * FROM Question1";

	$result=mysqli_query($connection,$queue);
	$numofrows=mysqli_num_rows($result);

	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$question = $row['question'];
		$type = $row['type'];
		$difficulty = $row['difficulty'];
		//$cases = $row['cases'];


		$combined=array();

 	$queue1 = "SELECT question_id, test_case FROM TestCases WHERE question_id = $questionid ";
  $result1=mysqli_query($connection,$queue1);
				while($row1=mysqli_fetch_assoc($result1))
				{
							$cases = $row1['test_case'];
							array_push($combined, array("cases"	=> $cases) );

				}
        $array[] = array("id" => $questionid,
                      "question" => $question,
                       "type" => $type,
                      "difficulty" 	=> $difficulty, $combined);

}
		echo json_encode($array, true);
	   mysqli_close($connection);

?>
