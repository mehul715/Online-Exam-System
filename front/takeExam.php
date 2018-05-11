<?php include "stuHead.php";?>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <style>
    * {
      padding: 0px;
      margin: 0px;
    }
    body {
      background-color: #ffffff;
      font-family: sans-serif;
    }

    #exam {
      padding: 15px;
    }
    textarea {
      width: 100%;
      height: 150px;
      padding: 12px 20px;
      margin: 10px 0px;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      resize: none;
    }
    .submitbutton {

      padding: 10px 40px;
      margin-top: 5px;
      font-weight: bold;
      letter-spacing: 1px;


    }
    .submitbutton:hover {
      color: white;
      background-color: #282830;
      cursor: pointer;
    }
    #exam {
      text-align: center;
    }
    #exam h3 {
      font-weight: normal;
      font-size: 15px;
    }
    #responstable {
      text-transform: capitalize;
      padding: 5px;
      margin: 3em auto;
      width: 40%;
      overflow: hidden;
      color: #024457;
      border-radius: 1px;
    }
    #responstable tr:nth-child(odd) {
      background-color: #dddddd;
    }
    #responstable th {
      display: none;
      background-color: #082759;
      color: #FFF;
      padding: 1em;

    }
    #responstable th:first-child {
      display: table-cell;
      text-align: center;
    }
    #responstable th:nth-child(2) {
      display: table-cell;
    }
    #responstable td {
      display: block;
      max-width: 2em;
      text-align: center;

    }
    #responstable th,
    #responstable td {
      text-align: center;
      margin: .5em 1em;
    }
    @media (min-width: 280px) {
      #responstable th,
      #responstable td {
        display: table-cell;
        padding: 1em;
      }
    }
    #review {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 50%;
		padding: 100px;
   height: 200px;
}
.table-border {
        border:1px solid black;
        padding: 10px;
        border-collapse: collapse;
    }
#review td, #review th {
    border: 1px solid #ddd;
    padding: 8px;
    
}

#review td {
	height: 70px;
	 
}

#review tr:nth-child(even){background-color: #f2f2f2;}

#review tr:hover {background-color: #ddd;}

#review th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #032254;
    color: white;}
  </style>
</head>


<body onload="sendtoexam()">

<center style="font-family:Roboto; font-size:40px;">Take Exam</center>
<br>
<br>
<br>
<br>
 <div id="selection">
    <form>
     <center>  <table id="review"></center>
      </table>
    </form>
  </div>


  <div id="examstarts">
    <h1 id=examheading style="text-align:center; padding: 50px;"></h1>
    <form id="exam"></form>
  </div>
  
  <img id="myImage"  style="width:10px"><br>
</body>


<script>

  var Exam_Id = 0;
  var question_ids = new Array();
  var username;

  function getUsername()
  {
    var parameters = location.search.substring(1).split("&");
    var temp = parameters[0].split("=");
    username= unescape(temp[1]);
  }

  function sendtoexam() {
  getUsername();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText);
        displayexam_list(response);
      }
    };
    xhr.open("GET", "takeExam_list.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
  }

  function displayexam_list(response) {

    var len = Object.keys(response).length;
    var html = "";
    var header = [ "Exam ID", "Exam"];
    var Exam_id = "";

    html += '<thead> <tr>';
    for (var index = 0; index < header.length; index++) {
      html += '<th style = "text-align: center">' + header[index] + '</th>';
    }

    html += '</tr> </thead>';
    html += '<tbody>';

    for (var i = 0; i < len; i++) {
      var Exam_id = response[i]["exam_id"];
      var Exam_name = response[i]["examname"];


      html += '<td>' + Exam_id + '</td>';

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          var response = JSON.parse(this.responseText);
            html += '<td>' + '<a href="#"' + "onclick=getExam(" + Exam_id + ")>" +  Exam_name + '</td>';

            html += '</tr>';

        }
      };


      xhr.open("POST", "takeExam_allExams.php?id=" + Exam_id, false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send();
      html += '</tbody>';
    }
    document.getElementById("review").innerHTML = html;
  }
  function getExam(id) {

    window.Exam_Id = id;
    document.getElementById("review").innerHTML = "";
    document.getElementById("selection").innerHTML = "";
  //  document.getElementById("examheading").innerHTML = "Exam Starts";
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var response = JSON.parse(this.responseText);
        console.log(response);
        displayExam(response);
      }
    };


    xhr.open("POST", "takeExam_requestExam.php?id=" + id, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();

  }
  function displayExam(response) {

    var questions_len = Object.keys(response).length;
    var exam = "";
    var questionID = "";

    for (var index = 0; index < questions_len; index++) {
      var question_id = response[index]['ID'];
      console.log(question_id);

      var question = response[index]['question'];
     console.log(question);

      var points = response[index]['points'];
      window.question_ids.push(question_id);

      //exam += '';
      //exam += '<button onclick="document.getElementById('myImage').src='thumbsDown.png' ">Will come later</button>';
      //exam += '<button onclick="document.getElementById('myImage').src='thumbsUp.png'">Already Done</button>';
      exam += '<h3 style="float:center;">' + (index + 1) + ") " + question + '<br>(Points = ' + points + ')' + '</h3>';
      exam += '<textarea rows="10" style="width:80%" placeholder="Answer..." id=' + question_id + ' class="questions">' + '</textarea>';
    }
    exam += '<br><br><button type="button" class="submitbutton" onclick="sendAnswers()">Submit</button>';
    document.getElementById("exam").innerHTML = exam;
  }
  function sendAnswers() {
    for (var index = 0; index < window.question_ids.length; index++) {
      var qu_id = window.question_ids[index];
      var response = {};

      response['exam_id'] = window.Exam_Id;
      response['ID'] = qu_id;
      response['answer_body'] = document.getElementById(qu_id).value;
      response['username']='mds39';



     console.log(JSON.stringify(response));


      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

             console.log(this.responseText);

        }
      };

      xhr.open("POST", "takeExam_store_Answers.php", false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(JSON.stringify(response));
      xhr.onreadystatechange = sendInstructor(Exam_Id);
    }
  }
  function sendInstructor(Exam_Id) {
    for (var index = 0; index < window.question_ids.length; index++) {
      var qu_id = window.question_ids[index];
      var response = {};
      response['exam_id'] = window.Exam_Id;

      response['username']= 'mds39';

            console.log("this is from front");


      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

             console.log(this.responseText);

        }
      };

      xhr.onreadystatechange = function(){
if(xhr.readyState == 4){
    //window.location.assign("stuFront.php");
    var ajaxDisplay = document.getElementById('exam');
    var res=xhr.responseText;
			  console.log(res);
    var html="<div class='submitted'>";
    html+='<h4><center><font size="+2">Exam Successfully Submitted</font></center></h4>';
     ajaxDisplay.innerHTML=html;
  }
};

      xhr.open("POST", "send_instructorexam.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(JSON.stringify(response));
    }
  }

</script>

</html>
