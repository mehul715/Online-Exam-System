<?php

     /*   $id = $_GET['id'];
        $user = $_GET['user'];

        $link = mysql_connect("sql2.njit.edu","mds39","shreekrishna");
        mysql_select_db('mds39');
        if($link == false){
                die('Could not connect to SQL');
        }

        $query = sprintf("select question, points, ID from Question1 where ID in (select
	ID from Exam2 where exam_id = %s);", $id);
        $result = mysql_query($query);
        $returnArray = array();
        while($row = mysql_fetch_array($result)){
                $returnArray[] = array('points' => $row['points'], 'questionid' => $row['ID'], 'question' => $row['question']);
        }
        $json = json_encode($returnArray);
        echo $json;
        mysql_close($link);*/


	$array = array();
	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

	$response = file_get_contents('php://input');
    $array  = json_decode($response,true);

	$arraysize= count($array);

	 $id = $_GET['id'];

	$sendarray[] = array("username" => $username);
	$sendarray[] = array("examid" => $examid, "examname" => $examname);

	$queue = "SELECT ID, question, points from Question1 where ID in (select ID from Exam2 where exim_id = '$id')";

	$result = mysqli_query($connection,$queue);
	

	while($row=mysqli_fetch_assoc($result)){
		$questionid = $row['ID'];
		$question    = $row['question'];
    $points      = $row['points'];



		$sendarray[] = array("questionid" => $questionid,
										   "question"    => $question,
                       "points"      => $points);


		}

		$finalarray = json_encode($sendarray);

		echo $finalarray;




?>
