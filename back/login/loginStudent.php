<?php

	$connection = mysqli_connect("sql2.njit.edu","mds39","shreekrishna","mds39");

    $array = array();
    $response = file_get_contents('php://input');
    $decoder = json_decode($response,true);


    $username = $decoder['Username'];
    $password = $decoder['Password'];
		$hashPass= md5($password);

    $result = mysqli_query($connection,"SELECT * FROM student WHERE username like '$username'");

    if(!$result){
      echo "\nNOT VALID QUERY";
    }

    $row = mysqli_fetch_assoc($result);

    $match = mysqli_num_rows($result);


    if ($match != 0){

        $name       = $row['username'];
        $pass       = $row['password'];
        $firstname  = $row['firstname'];
        $lastname   = $row['lastname'];

        //echo $lastname;

        if($hashPass == $pass){
            $array = array("Response"=>"Accepts", "firstname" => $firstname, "lastname" => $lastname);

            echo json_encode($array,true);
        }
        else{
        $log = array("Response"=>"Rejects");

        echo json_encode($log,true);
        }

    }
    else{
        $log = array("Response"=>"Rejects");

        echo json_encode($log,true);
    }

    mysqli_close($connection);                                                   
?>
