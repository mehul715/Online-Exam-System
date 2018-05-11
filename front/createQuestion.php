<?php include "insHead.php";?>
<style>
*{float: none; }
.submitbutton {


      font-weight: bold;
      letter-spacing: 1px;
      /*position: fixed;*/
      float: none;
      background-color: 	#021838;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
.submitbutton:hover{
  background-color: black;
}
.col-md-20{
	background-color:#dddddd;
	border-style:groove;
	border-width:8px;
	border-radius:8px;
}


/*#text1 {align:center;}

#text2 {align:center;}*/

/*.move {margin-left: -900px; }*/
.col-md-7{
	/*background-color:#dddddd;
	border-style:groove;
	border-width:7px;
	border-radius:8px;*/

 font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 50%;
		padding: 10px;
}

.Bank {
font-family: "Roboto", sans-serif;
color: white;
}


</style>
<body>
<center>





 <center style="font-family:Roboto; font-size:40px;">Create Question</center></br>
   <div>
 <!--Question Bank HTML and styles -->
			<div class="col-md-7" style="float:right; width:50%; border-style:rounded;">
				<div class="panel panel-info">
					<div class="panel-heading" style="background-color:#082759;">
						<div class = "Bank"><center><font size="18px;">Question Bank</font></center>
            </div>
					</div>
					<div id="questions"></div>
          </div>
				</div>
			</div>


 </center>



      <div align="middle" style="float:none">
      <br>
      <br>


       	<textarea rows=10 cols="80" name="description" id="description"  placeholder="Enter a question here...."></textarea>




     <br>
     <br>
     <br>



      <label>Type
				<select name="type" id="type">
					<option></option>
					<option value="for">For</option>
					<option value="while">While</option>
				 <option value="method">Method</option>
				 <option value="add">add</option>
				 <option value="multiple">multiply</option>
				 <option value="subtract">subtract</option>
				  <option value="division">division</option>
					<option value="function">function</option>
          <option value="factorial">factorial</option>
				</select>
			</label>

			<label>Difficulty
				<select name="difficulty" id="difficulty">
					<option></option>
					<option value="easy">Easy</option>
					<option value="medium ">Medium</option>
					<option value="hard">Hard</option>
				</select>
			</label>


     <br>
     <br>
		 <br>
      <br>






      <div id="cases">

          Case 1<input type="text" id="testcases" name="myInputs[]">

          Case Answer 1<input type="text" id="testcaseAns" name="myInputs[]">



       </div>
       <input type="button" value="Add another test case" id="test" onClick="addInput('cases');" >
       <br>
       <br>
       <br>

      <input type="button" class="submitbutton" value="Submit" onclick="addQuestion();">

      </div>










</body>
<script language="javascript">

var counter = 1;
var limit = 6;
var text=0;


function addInput(divID){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<label id='text1'>" +  "Case " + (counter + 1) + "<input type='text' name='myInputs[]' style='float:none;' > ";
          newdiv.innerHTML += "<label id='text2'>" + "Case Answer " + (counter + 1) + "<input type='text' name='myInputs[]' style='float:none;'><br>"
           document.getElementById(divID).appendChild(newdiv);
           //var caseans = document.createElement('div2');
           //caseans.innerHTML = "<label id='text2'>" + "Case " + (counter + 1) + "<input type='text' name='myInputs[]'>";
          //document.getElementById(divID).appendChild(caseans);
          counter++;


     }
}

var testCases=[];
function addQuestion(){
			var request = new XMLHttpRequest();

            var description=document.getElementById("description").value;
            var regex = new RegExp("'","g");
            //var newDescription = description.replace(regex,"''");

            var type=document.getElementById("type").value;
            var difficulty=document.getElementById("difficulty").value;
           // var testcases = document.getElementById("testcases").value;


           var testcases = document.getElementsByName("myInputs[]");
           console.log(testcases);

          console.log(testcases.length);
           for (var i = 0; i < testcases.length; ++i) {

            testCases.push(testcases[i].value.replace(regex, "''"));




           }
           //testcases.replace(regex,"''");



           //var testcases1 = document.getElementsByName("myInputs[]")[0].value;

           //var newCase1 = testcases1.replace(regex,"''");
           //var caseans1 = document.getElementsByName("myInputs[]")[1].value;

            //var testcases2 = document.getElementsByName("myInputs[]")[2].value;


           //var caseans2 = document.getElementsByName("myInputs[]")[3].value;
           //var newAnsCase2 = caseans2.replace(regex,"''");


            //var testcases3 = document.getElementsByName("myInputs[]")[4].value;
           // var newCase3 = testcases3.replace(regex,"''");

           //var caseans3 = document.getElementsByName("myInputs[]")[5].value;
           //var newAnsCase3 = caseans3.replace(regex,"''");


            //var testcases4 = document.getElementsByName("myInputs[]")[6].value;
           // var newCase4 = testcases3.replace(regex,"''");
           //var caseans4 = document.getElementsByName("myInputs[]")[7].value;
           //var newAnsCase4 = caseans3.replace(regex,"''");





            var myJSONObject={"question":description, "type":type, "difficulty":difficulty, "case1":testCases[0], "case_ans1":testCases[1],
                               "case2":testCases[2], "case_ans2":testCases[3], "case3":testCases[4], "case_ans3":testCases[5], "case4":testCases[6],
                               "case_ans4":testCases[7], "case5":testCases[8], "case_ans5":testCases[8], "case6":testCases[9], "case_ans6":testCases[9]};


            console.log(JSON.stringify(myJSONObject));

            request.open("POST", "createQuestion_middle.php", true);

            request.send(JSON.stringify(myJSONObject));



            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){

            /*window.location.assign("createSubmitted.php"); */


            }
        }
}

var length;
var RightArr=[];
var LeftArr=[];
var points=[];
var xhr = new XMLHttpRequest();


xhr.onreadystatechange = function(){
	if(xhr.readyState == 4){
		var leftDisplay = document.getElementById('questions');
		//var rightDisplay = document.getElementById('test');

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
    //lefthtml+='<th width="100">Cases</th>';
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
/*
      for(k=0;k<caseHit.length;k++){
        var cases = data[i]['0'][k]['cases'];

        if(cases != undefined){
                     stringhit += cases + "\n";
										 stringhit += "<br>";
           }
        }

*/

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


			//righthtml+="<tr hidden id='"+"tr"+data[i]['id']+"'><td>";

			//righthtml+='<br>'+[i+1]+'.&nbsp'+'&nbsp'+data[i]['question']+'</td>';


			//righthtml+='<td><input type="text"';
			//righthtml+='id="'+points[i]+'" name="point" onkeyup="findTotal()"';
			//righthtml+='placeholder="Input Points" style="border:none;width:100%;"/></td>';

			//righthtml+='</tr>';



		}


		lefthtml+="</tbody></table>";
		lefthtml+="</div></div>";
		//righthtml+="</tbody></table>";
		//righthtml+='</div></div>';




		leftDisplay.innerHTML=lefthtml;
		//rightDisplay.innerHTML=righthtml;

	}
}




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






xhr.open("POST","createExam_middle2.php", true);
xhr.send(null);

</script>
