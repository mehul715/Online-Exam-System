

<?php

$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

  $response = file_get_contents('php://input');
  $array  = json_decode($response,true);
  //print_r($array);
  $username=$array[0]['username'];//WITHOUT USERNAME THIS WONT WORK
  $transarray=array("username"=>$username);
  //print_r($array);
  extract($transarray);

$queue1="SELECT DISTINCT exam_id, examname,graded FROM Exam2 WHERE released like 'yes' ";
//$queue1="SELECT * from Exam2 ";
  $result1=mysqli_query($connection,$queue1);

$row=mysqli_fetch_assoc($result1);

//$array2[]=array("username"=>$username);
  if($row!=0){
      $array2[] = array("response" => "yes");
  		while($row=mysqli_fetch_assoc($result1))
  	{

    $examid		=$row['exam_id'];
    $examname	=$row['examname'];
    $grade = $row['graded'];
    $array2[]=array("exam_id" =>$examid, "examname" => $examname,"grade" => $grade);
}
}else{
	$array2[] = array("response" => "none");
	}
    echo json_encode($array2,true);
  	mysqli_close($connection);



?>
