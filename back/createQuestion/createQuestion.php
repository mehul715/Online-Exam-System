<?php




	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

    $response = file_get_contents('php://input');
    $array  = json_decode($response,true);


			$question    = $array['question'];
			$points 		= $array['points'];
			$case1		   = $array['case1'];
			$case_ans1   = $array['case_ans1'];
			$case2		   = $array['case2'];
			$case_ans2   = $array['case_ans2'];
			$case3		   = $array['case3'];
			$case_ans3   = $array['case_ans3'];
			$case4		   = $array['case4'];
			$case_ans4   = $array['case_ans4'];

			$difficulty  = $array['difficulty'];
			$type = $array['type'];

			$result = mysqli_query($connection,"SELECT max(ID) FROM Question1");
			$row= mysqli_fetch_assoc($result);


			$idmax=$row['max(ID)'];
			$idmax=$idmax+1;

			$queue = "INSERT INTO Question1 (id, question, points, difficulty, type) VALUES
			('$idmax','$question','$points', '$difficulty', '$type')";

			$result = mysqli_query($connection,$queue);

//// ADD CASE 1

			$result2 = mysqli_query($connection,"SELECT max(test_case_id) FROM TestCases");
			$row2= mysqli_fetch_assoc($result2);


			$idmax2=$row2['max(test_case_id)'];
			$idmax2=$idmax2+1;


			$queue2 = "INSERT INTO TestCases VALUES('$idmax2','$idmax','$case1','$case_ans1','0')";

			$result2 = mysqli_query($connection,$queue2);

//// ADD CASE 2
if($case2 != NULL){
			$result3 = mysqli_query($connection,"SELECT max(test_case_id) FROM TestCases");
			$row3= mysqli_fetch_assoc($result3);


			$idmax3=$row3['max(test_case_id)'];
			$idmax3=$idmax3+1;


			$queue3 = "INSERT INTO TestCases VALUES('$idmax3','$idmax','$case2','$case_ans2','0')";

			$result3 = mysqli_query($connection,$queue3);

}
//// ADD CASE 3
if($case3 != NULL){
			$result4 = mysqli_query($connection,"SELECT max(test_case_id) FROM TestCases");
			$row4= mysqli_fetch_assoc($result4);


			$idmax4=$row4['max(test_case_id)'];
			$idmax4=$idmax4+1;


			$queue4 = "INSERT INTO TestCases VALUES('$idmax4','$idmax','$case3','$case_ans3','0')";

			$result4 = mysqli_query($connection,$queue4);
}
//// ADD CASE 4
if($case4 != NULL){
			$result5 = mysqli_query($connection,"SELECT max(test_case_id) FROM TestCases");
			$row5= mysqli_fetch_assoc($result5);


			$idmax5= $row5['max(test_case_id)'];
			$idmax5= $idmax5+1;


			$queue5 = "INSERT INTO TestCases VALUES('$idmax5','$idmax','$case4','$case_ans4','0')";

			$result5 = mysqli_query($connection,$queue5);

}



				$response = array("response"=>"created");
				echo json_encode($case1);

?>
