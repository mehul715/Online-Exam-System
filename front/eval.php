<?php include "mid.php";?>
<?php include "stuHead.php";?>
<?php session_start();?>
<style>
	textarea{
  width:500px;
		border:none;
	        }
#review {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 60%;
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
	 width: 50%;
}

#review tr:nth-child(even){background-color: #f2f2f2;}

#review tr:hover {background-color: #ddd;}

#review th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #032254;
    color: white;}
input[type=checkbox] {
   margin:0px;
   padding:0px;
   margin-top:17px;
   margin-left:25px;
   width:14px;
   height:14px;
   transform: scale(1.5);
}
</style>

<center><h3>Student Review Exam</h3></center>



</div>
<div align="middle">

	<div class="row">
		<div class="col-md-4">
				<div class="panel panel-warning">
					<div class="panel-heading">

					</div>
					<div id="exams"></div>
				</div>
			</div>
	</div>

</div>

<div id="ajaxDiv"></div>
<br><br>
<?php include "footer.php";?>



<script>
try{ajaxRequest = new XMLHttpRequest();}
catch (e){try{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");}
catch (e){try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");}
catch (e){alert("BROWSWER ERROR");}
	}
}

var length;
		var finalarray =[];

ajaxRequest.onreadystatechange = function(){

	if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200){

			var return_data = ajaxRequest.responseText;
								//console.log(return_data);


								var Display = document.getElementById('exams');

								var data = JSON.parse(return_data);
								//console.log(data);

								var len=data.length;
								legnth=len;

									var html="<div class='row'>";
									html+="<div class='col-md-4'>";
									html+="<table id='review'>";
									html+="<thead style='background-color:#42ABCA;'><tr><th>Check</th>";
								//	html+="<th>Username of student</th>";
									html+="<th>Exam ID</th>";
									html+="<th>Exam Name</th>";
									html+="<th>Graded</th>";
									//html+="<th>Professor</th>";
								//	html+="<th>Submission Status</th>";

									html+="</tr></thead>";
									html+="<tbody>";

									//console.log(len);
									for(var i=1;i<len;i++){
										var examid = data[i]['examid'];
										var examname = data[i]['examname'];
                     var grade = data[i]['grade']; 
										if(grade == ''){
											var check ='<p>&#10060;</p>';
										}
										else {
											 check='<p>&#9989;</p>';
										}
									//	var professor = data[i]['professor'];
									//	var studentusername = data[0]['studentusername'];
									//	var submissionstatus = data[i]['submitted'];
										var fusion =  examid + '|' + examname;

										html+="<tr><td>";
										html+='<input type="checkbox" name="examlist" onclick="onlyOne(this)" id="'+examid;
										html+='" value="' +fusion+'"'+'></td>';
										//html+='<input type="hidden" name="examnamelist" value="' +data[i]['examname']+'"'+'></td>';

									//	html+='<td><br>'+studentusername+'</td>';
										html+='<td><br>'+examid+'</td>';
										html+='<td><br>'+examname+'</td>';
										html+= '<td><br>'+check +'</td>';
									//	html+='<td><br>'+professor+'</td>';
									//	html+='<td><br>'+submissionstatus+'</td>';

					}
						html+="</tbody></table>";
	html+="</div></div>";


	html+='<br><br><input type="button" value="Review Exam" class="btn btn-info" onclick="reviewexam();"/>';
	Display.innerHTML=html;


	}

}

var username = "<?php echo $_SESSION['username']; ?>";
			var sendarray=[];
			sendarray.push({username:username});
			var chkbox=document.getElementsByName("studentlist");


			for(var i=0;i<chkbox.length;i++){


					if(chkbox[i].checked){

							var studentid=chkbox[i].id;
							var studentusername=chkbox[i].value;
							sendarray.push({studentid:studentid,studentusername:studentusername});

					}
				}
				//console.log(sendarray);

				ajaxRequest.open("POST", "eval_back.php", true); //php release from midddle
			 //file get contents, decode, function, CURLS
				ajaxRequest.send(JSON.stringify(sendarray));


var FEEDBACK=[];
var CASES = [];
function reviewexam(){
			var ajaxRequest;  //BROWSWERS
			try{ajaxRequest = new XMLHttpRequest();}
			catch (e){try{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");}
			catch (e){try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){
			//ERROR
			alert("BROWSER ERROR");
						}
					}
				}



			ajaxRequest.onreadystatechange = function(){

					if(ajaxRequest.readyState == 4){


					  var res=ajaxRequest.responseText;
					  console.log(res);

						var Display = document.getElementById('exams');

						var res=ajaxRequest.responseText;
					//	alert(res);

						var data=JSON.parse(res);

            //var result = removeDuplicates(data);
						var len=data.length;



						//console.log(data);
						var examid = data[1]['examid'];
						var examname = data[1]['examname'];
						var professor = data[1]['professor'];
						var grade = data[1]['newGrade'];
						var html='<div class="containers">';
						var questionid = data[2]['questionid'];



					html+='<br><br><h4><center><font size="+2">Exam name:'+examname+'<br></font></center></h4>';
					html+='<h4><center><font size="+2">Grade: '+grade+'</font></center></h4>';
				//	html+='<label>New Grade  </label><textarea rows="1" style="width:10%;border:solid 2px black;" id="grade"></textarea><br><br></div>';

                var feedback = data[0]['feedback'];


								for(var i=2;i<len;i++){
										var caseshit ="";
										var casesmissed="";
										var casepoints="";
										//var hi = "<span style='color:#ff0000'>hi</span>";

										var question=data[i]['question'];
										var answer = data[i]['answer'];
										var stringhit="";
										var stringmissed="";
                    var feedback = data[i]['feedback'];
										var questionid = data[i]['questionid'];
                    var variableMatch = data[i]['variableMatch'];
										var substring="2 point";
										if(variableMatch.includes(substring)){
											   variableMatch += "<br><span style='color:#ff0000'>(-2 Points)</span>";
										}


                    var functionName = data[i]['functionName'];
										if(functionName.includes(substring)){
												 functionName += "<br><span style='color:#ff0000'>(-2 Points)</span>";
										}
                    var pointsgot= data[i]['totalCasePoints'];
                    var pointstotal=data[i]['pointstotal'];

                    var caseHit = data[i]['0'];


										FEEDBACK.push(questionid);
										html+='<div style="font-size:26px; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;"><b><p>Problem '+(i-1)+'</b>';
										html+='<br><b><p>Question:  </b>'+question+'</p>';
										html+='<div align="middle" style="border-left:6px;"><label>Answer</label><br><textarea rows="10" style="width:30%;border:solid 2px black;" id="'+data[i]['questionid']+'"readonly>'+answer +'</textarea><br><br></div>';
										html += "<table id='review'>";
												 //html += "<tr><th>Question</th>";
												 //html += "<th>Answer</th>";
												 html += "<th>Case Success</th>";
												  html += "<th>Case Points Earned</th>";
												 html += "<th>Case Fail</th>";

												 html += "<th>Variable Match</th>";
												 html += "<th>Function Name</th>";
												 //html += "<th>Enter Feedback</th></tr>";
												 html += "<th>Points Got</th>";
												html += "<th>Points Total</th></tr>";

												 html += "<tbody>";

                   for(k=0;k<caseHit.length;k++){
                     var caseshit = data[i]['0'][k]['caseshit'];
                     var casesmissed = data[i]['0'][k]['casesmissed'];
										 var casePoints = data[i]['0'][k]['casePoints'];
                     //console.log(caseshit);
                     //console.log(casesmissed);
										 if(caseshit != undefined){
                     stringhit += caseshit + "\n";
										 stringhit += "<br>";
										 casepoints+= "+"+casePoints;
										 casepoints+= "<br>";


									 }
                     if(casesmissed != null){
                     stringmissed += casesmissed + "\n";

                     }
                     //console.log(stringhit);
                     //console.log(stringmissed);
                   }



                   html += "<tr id='review2' >";
                   //html +='<td id="'+data[i]['questionid']+'">'+question+'</td>';
                   //html +='<td style="width:20%;" id="'+data[i]['questionid']+'">'+answer+'</td>';
                   html +='<td id="'+data[i]['questionid']+'">'+stringhit+ '</td>';
									 html +='<td style="color:green;" id="'+data[i]['questionid']+'">'+casepoints+ '</td>';
                   html +='<td id="'+data[i]['questionid']+'">'+stringmissed+ '</td>';

                   html +='<td id="'+data[i]['questionid']+'">'+variableMatch+'</td>';
                   html +='<td id="'+data[i]['questionid']+'">'+functionName+'</td>';
									 html +='<td id="'+data[i]['questionid']+'">'+pointsgot+'</td>';
                   html +='<td id="'+data[i]['questionid']+'">'+pointstotal+'</td>';
                   html +="</tr>";
									 html +="</table>";


/*
									 html += "<table align='left' id='review2'  >";
									 html += "<tr >";
                   //html +='<td id="'+data[i]['questionid']+'">'+question+'</td>';
                   //html +='<td style="width:20%;" id="'+data[i]['questionid']+'">'+answer+'</td>';
									 html +='<td  id="'+data[i]['questionid']+'">'+pointstotal+'</td>';

                  html +='<td  id="'+data[i]['questionid']+'">'+pointstotal+'</td>';

                   html +="</tr>";
									 html +="</table>";
*/











										//html+='<div><p><em>Problem '+(i-1)+':</em>';
                    //html+='<div><p><em>Points Got: '+pointsgot+'</em>';
                    //html+='<br><em>Points Total: '+pointstotal+'</em>';
										//html+='<br><p>'+question+'</p>';
										//html+='<label>Your answer</label><br>';
										//html+='<textarea rows="10" style="width:30%;border:solid 2px black;" id="'+data[i]['questionid']+'">'+answer +'</textarea><br><br></div>';
                     html+='</tbody></table>';
                    html+='<br><br>';
                     html+='<div align="middle" style="border-left:6px;"><label style="font-size:22px;">Feedback</label><br><textarea rows="10" style="width:70%; border-style:solid; border-width:2px;" readonly id="'+data[i]['questionid']+'">'+feedback+'</textarea><br><br></div>';



							}//end of for loop





//html+='<div align="middle" style="border-left:6px;"><label>Feedback</label><br><textarea rows="10" id="feedback'+questionid+'" style="width:20%; border:solid 2px black;border-radius: 5px;border-left:6px solid ;font-weight:bold;" id="'+data[i]['questionid']+'">'+feedback +' </textarea><br><br></div>';
										//html+='<br><br><input type="button" value="Submit Changes" class="btn btn-info" onclick="submit();"/>';
										html+='</div></div>';
										Display.innerHTML=html;





			}}





			var chkbox=document.getElementsByName("examlist");

			for(var i=0;i<chkbox.length;i++){


					if(chkbox[i].checked){

							var examid=chkbox[i].id;
							var fusion2=chkbox[i].value;
							var fusionarray = fusion2.split('|');
							var studentusername = fusionarray[0];
							var examname = fusionarray[2];
							var professor = fusionarray[3];

							finalarray.push({studentusername:studentusername,examid:examid,examname:examname,professor:professor})
							var sendarray={username:studentusername,examid:examid,examname:examname,professor:professor};

					}
				}
			//	console.log(sendarray);

				ajaxRequest.open("POST", "eval_back_show.php", true); //php release from midddle
			 //file get contents, decode, function, CURLS
				ajaxRequest.send(JSON.stringify(sendarray));
}

function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('examlist')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

/*function submit(){
			var ajaxRequest;
			try{ajaxRequest = new XMLHttpRequest();}
			catch (e){try{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");}
			catch (e){try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){alert("BROSWER ERROR");}
						}
					  }

			ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){


			  var ajaxDisplay = document.getElementById('exams');
			  var res=ajaxRequest.responseText;
			//  console.log(res);



			 var html="<div class='submitted'>";

			 html+='<h4><center><font size="+2">Exam Successfully Updated</font></center></h4>';
			  html+='</div>';
			  ajaxDisplay.innerHTML=html;


					}
			}
		var len=FEEDBACK.length;
		var newgrade = document.getElementById("grade").value;
		console.log(newgrade);
		finalarray.push({newgrade:newgrade});
		//for(var i=0;i<len;i++){

			var feedback=document.getElementById("feedback"+FEEDBACK[0]).value;
      console.log(feedback);

			finalarray.push({questionid:FEEDBACK[0],feedback:feedback});
	//}


	//console.log(finalarray);


	ajaxRequest.open("POST", "reviewExam_updateexam.php", true);
	ajaxRequest.send(JSON.stringify(finalarray));
	}*/

</script>
