<?php


$connection =  mysql_connect("sql2.njit.edu","mds39","shreekrishna");
mysql_select_db('mds39');

$response = file_get_contents('php://input');
$array  = json_decode($response,true);
$id =	$array['id'];


	$query = "SELECT * FROM TestCases WHERE question_id = $id";
	$result = mysql_query($query);
	$array1 = array();
	while($row = mysql_fetch_array($result)){
		$array1[] = array('case_id' => $row['test_case_id'], 'questionID' => $row['question_id'],
		'test_case' => $row['test_case'], 'case_answer' => $row['test_case_answer']);
	}
	$json = json_encode($array1);
	echo $json;
	mysql_close($connection);

?>
