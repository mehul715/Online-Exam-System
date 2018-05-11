<?php

        $id = $_GET['id'];
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
                $returnArray[] = array('points' => $row['points'], 'ID' => $row['ID'], 'question' => $row['question']);
        }
        $json = json_encode($returnArray);
        echo $json;
        mysql_close($link);



?>
