<?php

  session_start();
  $str_json = file_get_contents('php://input');
  $arrayJSON= json_decode($str_json, true);

  $data = array(
    'exam_id'  => $arrayJSON[exam_id],
    'ID' => $arrayJSON[ID],
    'answer_body' => $arrayJSON[answer_body],
    'username' => $arrayJSON[username]
);

  $url = 'https://web.njit.edu/~mmp39/CS490/master/middle/studentExam/store_Answers.php';
  $ch = curl_init($url);

  $jsonDataEncoded = json_encode($data);


  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

  $result = curl_exec($ch);
  echo $result;

?>
