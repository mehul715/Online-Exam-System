<?php


  $id = $_GET["id"];
	$curl = curl_init();
	curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => "https://web.njit.edu/~mmp39/CS490/master/middle/studentExam/takeExam_requestExam.php?id=". $id));
	$result = curl_exec($curl);
	echo $result;
?>
