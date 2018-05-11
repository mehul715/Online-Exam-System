<?php

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);
  	$arraysize= count($array);
    print_r("came from instructor");
print_r ($array);


   $exam_id = $array['exam_id'];
   $username = $array[$i]['username'];
   $ID = $array[$i]['questionid'];
   $answer = $array[$i]['ans'];
   $examname = $array[$i]['examname'];



   	$queue="UPDATE Exam2 set released = 'yes' where Exam_Id='$exam_id'";
    $result=mysqli_query($connection,$queue);





?>
