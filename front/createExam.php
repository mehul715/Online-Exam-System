<?php include "insHead.php";?>
<?php session_start();?>
<head>
<style>


.Bank {
font-family: "Roboto", sans-serif;
color: white;
}
.button {
        clear: center;
        float: center;
				position:absolute;

	top: 50%;
	left: 53%;
    }
div.textbox {
    margin-left: 50%;
    bottom: -15px;
    font-weight: bold;
    font-size: 18px;
}
input[type=checkbox] {
   margin:0px;padding:0px;
   margin-top:17px;
   margin-left:25px;
   width:14px;
   height:14px;
   transform: scale(1.5);
}
.align{
  margin-left: 470px;
}
.submitbutton {
      padding: 3px 5px;
      margin-top: 2px;
      font-weight: bold;
      letter-spacing: 1px;
      margin-left: 50px;
}
.submitbutton:hover {
      color: white;
      background-color: #282830;
      cursor: pointer;
}
#total { align: left; }

#review {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
		padding: 10px;
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

#review2 {
	height: 200px;
	 width: 90%;
}

#review tr:nth-child(even){background-color: #f2f2f2;}

#review tr:hover {background-color: #ddd;}

#review th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #032254;
    color: white;}

#myInput { transform: scale(1.5);
            margin-left: 60px; }

</style>




<body>

	<div id="user">
	</div>
	<div name="editExamTable" id="editExamTable">
		<center>
		<br>
   <br>
   <br>

   <div class = "textbox" >
			<input type="text" placeholder='Exam Title' style=" transform: scale(1.5); position:center;" name="examname" id="examname">
            <input type="button" class="submitbutton" value="Done" onclick="addExam();">
            </div>

		</center>

    <input type='text' id='myInput' onkeyup='Search()' placeholder='Search..'>
    <br>
    <br>
		<div id="output"></div>

    <!--Question Bank HTML and styles -->
			<div class="col-md-7" style="float:left; width:50%; border-style:rounded;">
				<div class="panel panel-info">
					<div class="panel-heading" style="background-color:#082759;">
						<div class = "Bank"><center><font size="18px;">Question Bank</font></center></div>
					</div>
					<div id="questions"></div>
				</div>
			</div>



     <!--Exam Bank HTML and styles -->
			<div class="col-md-7" style="float:right; width:40%; border-style:rounded;">
				<div class="panel panel-warning">
					<div class="panel-heading" style="background-color:#082759;">
						<div class= "Bank"><center><font size="18px";>Exam</font></center></div>
					</div>
					<div id="test"></div>
				</div>
			</div>
		</div>


	</div>

<div class=button
			<center>
			<input type="button"  class="submitbutton" value="Right" style="position: center;" onclick="addQuestion();">
        <br><br>

      <br><br>

        </center>
</div>
	</div>
	<div id="alert"></div>


<br>
</body>
</head>

<script language="Javascript">

var length;
var RightArr=[];
var LeftArr=[];
var points=[];
var xhr = new XMLHttpRequest();




xhr.onreadystatechange = function(){
	if(xhr.readyState == 4){
		var leftDisplay = document.getElementById('questions');
		var rightDisplay = document.getElementById('test');

		var res=xhr.responseText;
   console.log(res);

		var data=JSON.parse(res);

		var len=data.length;
		length=len;

		console.log(data);

		var lefthtml="<div class='row'>";
		lefthtml+="<div class='col-md-12'>";
		lefthtml+="<table id='review'>";
		lefthtml+="<thead style='background-color:#42ABCA; color:white;'><tr><th>Check</th>";

		lefthtml+='<th width="1000">Question</th>';
    //lefthtml+='<th width="100">Type</th>';
    lefthtml+= '<th><select id="question_option_select2" onchange="showQuestions2()">';
		lefthtml+=		'<option value="">Type</option>';
		lefthtml+=		'<option value="method">method</option>';
		lefthtml+=		'<option value="for">for</option>';
		lefthtml+=		'<option value="add">add</option>';
    lefthtml+=		'<option value="multiple">multiple</option>';
    lefthtml+=		'<option value="subtract">subtract</option>';
    lefthtml+=		'<option value="divide">divide</option>';
		lefthtml+=	'</select></th>';

    lefthtml+= '<th><select id="question_option_select" onchange="showQuestions1()">';
		lefthtml+=		'<option value="">Difficulty</option>';
		lefthtml+=		'<option value="easy">easy</option>';
		lefthtml+=		'<option value="medium">medium</option>';
		lefthtml+=		'<option value="hard">hard</option>';
		lefthtml+=	'</select></th>';
    //lefthtml+='<th width="100">Type</th>';
    lefthtml+='<th width="100">Cases</th>';
    lefthtml+="</tr></thead>";
		lefthtml+="<tbody>";

		var righthtml ='<div>';
		righthtml+='<div>';

		righthtml+="<table class='table table-striped'>";
    righthtml+="<table id='review'>";
		righthtml+="<thead style='background-color:#42ABCA; color:white;'><tr>";
		//righthtml+='<th width="200">Check</th>';
		righthtml+='<th width="1000">Question</th>';
		righthtml+="<th style='width:25%;'>Points</th></tr>";
		righthtml+='</thead><tbody>';

		var pointsTotal;



		for(var i=0;i<len;i++){

      var cases = "";
      var stringhit ="";
      var caseHit = data[i]['0'];

      for(k=0;k<caseHit.length;k++){
        var cases = data[i]['0'][k]['cases'];

        if(cases != undefined){
                     stringhit += cases + "\n";
										 stringhit += "<br>";
           }
        }



			LeftArr.push(data[i]['id']);
			RightArr.push("test"+data[i]['id']);
			points.push("points"+data[i]['id']);

			lefthtml+="<tr><td>";

			lefthtml+='<input type="checkbox" name="questionlist" id="'+data[i]['id'];
			lefthtml+='" value="'+data[i]['id']+'"'+'></td>';

			lefthtml+='<td><br>'+[i+1]+'.&nbsp'+'&nbsp'+data[i]['question']+'</td>';
			lefthtml+='<td><br>'+data[i]['type']+'</td>';


			lefthtml+='<td><br>'+data[i]['difficulty']+'</td>';
      lefthtml+='<td id="'+data[i]['questionid']+'">'+stringhit+'</td>';

			lefthtml+='</tr>';


			righthtml+="<tr hidden id='"+"tr"+data[i]['id']+"'><td>";

			righthtml+='<br>'+[i+1]+'.&nbsp'+'&nbsp'+data[i]['question']+'</td>';


			righthtml+='<td><input type="text"';
			righthtml+='id="'+points[i]+'" name="point" onkeyup="findTotal()"';
			righthtml+='placeholder="Input Points" style="border:none;width:100%;"/></td>';

			righthtml+='</tr>';



		}


		lefthtml+="</tbody></table>";
		lefthtml+="</div></div>";
		righthtml+="</tbody></table>";
		righthtml+='</div></div>';




		leftDisplay.innerHTML=lefthtml;
		rightDisplay.innerHTML=righthtml;

	}
}



xhr.open("POST","createExam_middle2.php", true);
xhr.send(null);


function showQuestions1(){
  var table, tr, td, i;
  var input = document.getElementById("question_option_select").value;
  table = document.getElementById("review");
  tr = table.getElementsByTagName("tr");
  for(i=0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if(td){
      if(td.innerHTML.indexOf(input) > -1){
        tr[i].style.display = "";
      }
      else{
        tr[i].style.display = "none";
      }
    }
  }
}

function showQuestions2(){
  var table, tr, td, i;
  var input = document.getElementById("question_option_select2").value;
  table = document.getElementById("review");
  tr = table.getElementsByTagName("tr");
  for(i=0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if(td){
      if(td.innerHTML.indexOf(input) > -1){
        tr[i].style.display = "";
      }
      else{
        tr[i].style.display = "none";
      }
    }
  }
}



function Search() {
	var filter, table, tr, td, i;
	var input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("review");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td1 = tr[i].getElementsByTagName("td")[1];
   td2 = tr[i].getElementsByTagName("td")[2];
   td3 = tr[i].getElementsByTagName("td")[3];


		if(td1 || td2 || td3){
			if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 || td3.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			}
      else {
				tr[i].style.display = "none";
			}
	  }
	}
}


function addQuestion(){
	for(var i=0;i<length;i++){
		var chkbox=document.getElementById(LeftArr[i]);
		if(chkbox.checked){
			document.getElementById('tr'+LeftArr[i]).hidden=false;
		}
	}
}



function addExam(){
			var request;
			try{request = new XMLHttpRequest();}
			catch (e){try{request = new ActiveXObject("Msxml2.XMLHTTP");}
			catch (e){try{request = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){alert("BROWSER ERROR!");
			return false;
						}
					}
				}


				request.onreadystatechange = function(){


					if(request.readyState == 4){
						var ajaxDisplay = document.getElementById('ajaxDiv');
						var res=request.responseText;
						console.log(res);
						}

				}

				var examname=document.getElementById("examname").value;



				var questions="";
				var out="";
				var sendarray =[];

				sendarray.push({examname:examname});

				for(var i=0;i<length;i++){
					var chkbox=document.getElementById(LeftArr[i]);
					var point=document.getElementById(points[i]).value;////


            	if(chkbox.checked){
							out+='<center>' + LeftArr[i] + '</center>';
							questions+=LeftArr[i];

							//	console.log(point);
							sendarray.push({questionid:LeftArr[i],points:point});////
				  }
        	}


				//console.log(sendarray);
				var leng = sendarray.length;







				if(examname==""){
					alert("You must input Exam Name");
				}
				else{
					request.onreadystatechange = function() {
						if(request.readyState == 4 && request.status == 200) {

						var res=request.responseText;

						//var data=JSON.parse(res);
						var message = 'You have created the exam '+ examname;
						alert(message);

						console.log(res);

						}
					}

					var myJSONObject=sendarray;
					request.open("POST", "createExam_middle.php", true);
					var send = JSON.stringify(myJSONObject);

					console.log(JSON.stringify(myJSONObject));


					request.send(send);

          window.location.assign("createExamSubmitted.php");
				}
}




</script>
