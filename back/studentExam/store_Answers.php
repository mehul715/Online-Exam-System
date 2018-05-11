<?php

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

$body = json_decode(file_get_contents('php://input'), true);
       $exam_id = $body['exam_id'];
       $question_id = $body['ID'];
       $username = $body['username'];
       $answer = $body['answer_body'];
        //$answer1 = $body['ans'];

   $queue = "INSERT INTO studentAnswers(exam_id, ID, username, answer) VALUES ('$exam_id','$question_id', '$username', '$answer')";

   $result = mysqli_query($connection,$queue);


   echo $answer;

?>
