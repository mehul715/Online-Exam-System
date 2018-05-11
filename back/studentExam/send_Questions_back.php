<?php

$connection =  mysql_connect("sql2.njit.edu","mds39","shreekrishna");
mysql_select_db('mds39');

$response = file_get_contents('php://input');
$array  = json_decode($response,true);
$id =	$array['id'];

	$query = "SELECT question, points FROM Question1 WHERE ID = $id";
	$result = mysql_query($query);
	$array1 = array();
	while($row = mysql_fetch_array($result)){
		$array1[] = array('question' => $row['question'], 'points' => $row['points']);
	}
	$json = json_encode($array1);
	echo $json;
	mysql_close($connection);


?>
