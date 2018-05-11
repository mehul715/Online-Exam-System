<?php include "mid.php";?>
<?php include "insHead.php";?>
<?php session_start();?>
<style>
	textarea{
  width:500px;
		border:none;
	        }
#review {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 50%;
		padding: 10px;
    table-layout: fixed;
}

.left {
    width: 22%;
    float: left;
    text-align: right;
		padding :-10px;

}

.right {
    width: 65%;
    margin-left:-14%;
		left:-5%;
		top:-20%;


}

#getexams {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 50%;
		padding: 10px;
}
.table-border {
        border:1px solid black;
        padding: 10px;
        border-collapse: collapse;
    }
#review td, #review th {
    border: 1px solid #ddd;
    padding: 20px;
}

#review2 {
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

<center><h3>Instructor Review Exam</h3></center>



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
									//html+="<th>Professor</th>";
								//	html+="<th>Submission Status</th>";

									html+="</tr></thead>";
									html+="<tbody>";

									//console.log(len);
									for(var i=1;i<len;i++){
										var examid = data[i]['examid'];
										var examname = data[i]['examname'];
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

				ajaxRequest.open("POST", "reviewExam_examlist.php", true); //php release from midddle
			 //file get contents, decode, function, CURLS
				ajaxRequest.send(JSON.stringify(sendarray));

var TOTALP=[];
var FEEDBACK=[];
var POINTS = [];
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
						var grade = data[1]['grade'];
						var newGrade = data[1]['newGrade'];
                         if(newGrade === null){
                           newGrade = '';
                         }
						var html='<div class="containers">';
						var questionid = data[2]['questionid'];
						var totalPoints = data[1]['totalPoints'];
						TOTALP.push(totalPoints);



					html+='<br><br><h4><center><font size="+2">Exam name:'+examname+'<br></font></center></h4>';
					html+='<h4><center><font size="+2">Total Grade: '+grade+'</font></center></h4>';
					html+='<h4><center><font size="+2"> New Grade: '+newGrade+'</font></center></h4>';
					//html+='<label>New Grade  </label><textarea rows="1" style="width:10%;border:solid 2px black;" id="grade"></textarea><br><br></div>';

                //var feedback = data[0]['feedback'];


								for(var i=2;i<len;i++){
										var casePassed ="";
										//var caseFailed="";
										var casepoints="";
                     var run = "";
                     var check = "";
										//var hi = "<span style='color:#ff0000'>hi</span>";
										var question=data[i]['question'];
										var answer = data[i]['answer'];
										var stringhit="";
										var stringmissed="";
                     var runAnswers="";
                     var feedback = data[i]['feedback'];
										 if(feedback ===null){

											 feedback ='';
										 }



										var questionid = data[i]['questionid'];
                    var variableMatch = data[i]['variableMatch'];
										var substring="not";
										if(variableMatch.includes(substring)){
											   variableMatch += "<span style='color:#ff0000'> (-2 Points)</span>";
										}



                    var functionName = data[i]['functionName'];
										if(functionName.includes(substring)){
												 functionName += "<span style='color:#ff0000'> (-2 Points)</span>";
										}


									var changedPoints=data[i]['changedPoints'];
									if(changedPoints ===null){

										changedPoints ='';
									}

                    var pointsgot= data[i]['totalCasePoints'];
                    var pointstotal=data[i]['pointstotal'];

                    var caseHit = data[i]['0'];


//html+="<div class='col-md-4'>";

										FEEDBACK.push(questionid);
                    POINTS.push(questionid);
										//html+='<div style="font-size:26px; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;"><b><p><u>Problem '+(i-1)+'</u></b>';
										html+="<div style='font-size:26px;'><br><b><p>Question "+(i-1)+": </b>"+question+"</p></div>";
										//html+='<div  style="border-left:6px;"><label>Answer</label><br><textarea rows="10" style="width:30%;border:solid 2px black;font-size:20px;" id="'+data[i]['questionid']+'" readonly>'+answer +'</textarea><br><br></div>';
										html+='<div class="left" ><label>Answer</label></div>';
										html+='<div class="right"><textarea rows="10" style="width:40%;border:solid 2px black;font-size:20px;" id="'+data[i]['questionid']+'" readonly>'+answer +'</textarea><br><br></div>';
										html+='<div ><b><p>Points: </b><textarea rows="1" id="changedPoints'+questionid+'" style="width:4%; height:4%; padding:4px; border-style:solid; border-width:2px;font-size:16px;" id="'+data[i]['questionid']+'">'+pointsgot+'</textarea>&nbsp;/&nbsp;'+pointstotal+'</p><br></div>';
										html += "<table id='review' style='width:70%'>";

												 html += "<th>Expected</th>";
                         html += "<th>Run</th>";
												  html += "<th style='width:20%;'>Points Earned</th>";

                         // html += "<th>Case Result</th>";
                          html += "<th style='width:8%;'>Check</th>";

												 html += "<tbody>";

                   for(k=0;k<caseHit.length;k++){
                     var casePassed = data[i]['0'][k]['casePassed'];
                      var run = data[i]['0'][k]['run'];
                      var success = data[i]['0'][k]['case_result'];
                      console.log(run);

										 var casePoints = data[i]['0'][k]['casePoints'];

										 html += "<tr id='review2' style='width:20%;' >";

										 html +='<td  style="font-size:20px;" id="'+data[i]['questionid']+'">'+casePassed+ '</td>';



											html +='<td  style="font-size:20px;" id="'+data[i]['questionid']+'">'+run+ '</td>';


										html +='<td style="color:green; font-size:20px;" id="'+data[i]['questionid']+'">'+casePoints+ '</td>';

                        //html +='<td  id="'+data[i]['questionid']+'">'+success+ '</td>';


                         if(data[i]['0'][k]['case_result']  === 'fail'){
                           var check ='<p>&#10060;</p>';
                      }
                     else  {
                          var check='<p>&#9989;</p>';
                     }

                     html += '<td style="text-align:center;">'+check+'</td>';
											html +="</tr>";








                   }




                     html +="</table>";

                   var string = "matched";


                     html += "<table id='review' style='width:70%'>";

                    html +='<td  style="font-size:20px;" id="'+data[i]['questionid']+'">'+variableMatch+'</td>';

                    if(data[i]['variableMatch'].includes(string)){

                              var Variablecheck='<p>&#9989;</p>';


                    }
                    else {
                              Variablecheck ='<p>&#10060;</p>';
                    }

                   html += '<td style="width:8% ;text-align:center;">'+Variablecheck+'</td>';

                   html +="</table>";


                   html += "<table id='review' style='width:70%'>";
                   html +='<td  style="font-size:20px;" id="'+data[i]['questionid']+'">'+functionName+'</td>';

                  if(data[i]['functionName'].includes(string)){

                              var Functioncheck='<p>&#9989;</p>';


                    }
                    else {
                              Functioncheck ='<p>&#10060;</p>';
                    }


                  html += '<td style="width:8% ;text-align:center;" >'+Functioncheck+'</td>';

									 html +="</table>";


                    html+='</tbody></table>';
                    html+='<br><br>';
                     html+='<div align="middle" style="border-left:6px;"><label style="font-size:22px;">Feedback</label><br><textarea rows="10" id="feedback'+questionid+'" style="width:50%; border-style:solid; border-width:2px;font-size:20px;" id="'+data[i]['questionid']+'">'+feedback+'</textarea><br><br></div>';

                     html+='<hr>';

							}//end of for loop





										html+='<br><br><input type="button" value="Submit Changes" class="btn btn-info" onclick="submit();"/>';
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

				ajaxRequest.open("POST", "reviewExam_getexam.php", true); //php release from midddle
			 //file get contents, decode, function, CURLS
				ajaxRequest.send(JSON.stringify(sendarray));
}

function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('examlist')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

function submit(){
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
   var len1 = POINTS.length;
		//var newgrade = document.getElementById("grade").value;

		//console.log(newgrade);
		console.log(TOTALP[0]);
		//finalarray.push({newgrade:newgrade});
var sum=0;
		for(var i=0;i<len1;i++){

			//var feedback=document.getElementById("feedback"+FEEDBACK[i]).value;
			var changedPoints = document.getElementById("changedPoints"+POINTS[i]).value;
      console.log(changedPoints);
       sum =sum + parseFloat(changedPoints);
			 console.log(sum);

			//finalarray.push({questionid:FEEDBACK[i],feedback:feedback,changedPoints:changedPoints});
	}
	var cgrade;
	cgrade=(sum/(TOTALP[0]))*100;
	var cgrade = Math.round( cgrade * 10 ) / 10;
	console.log(cgrade);
	finalarray.push({newgrade:cgrade});


/*
    for(var j=0; j<len1; j++) {
     var changedPoints = document.getElementById("changedPoints"+POINTS[j]).value;
    console.log(changedPoints);
     finalarray.push({questionid:POINTS[j], changedPoints:changedPoints});
    }

*/
		for(var i=0;i<len;i++){

			var feedback=document.getElementById("feedback"+FEEDBACK[i]).value;
			var changedPoints = document.getElementById("changedPoints"+POINTS[i]).value;
			console.log("check");
      console.log(feedback);

			finalarray.push({questionid:FEEDBACK[i],feedback:feedback,changedPoints:changedPoints});
	}


	console.log(finalarray);


	ajaxRequest.open("POST", "reviewExam_updateexam.php", true);
	ajaxRequest.send(JSON.stringify(finalarray));
	}

</script>
