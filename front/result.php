<?php include "stuHead.php";?>
<?php session_start(); ?>

<style>
.col-md-7{
	background-color:#dddddd;
	border-style:groove;
	border-width:7px;
	border-radius:8px;
}
.Bank {
font-family: "Roboto", sans-serif;
color: white;
}
.submitbutton {
      padding: 3px 5px;
      margin-top: 2px;
      font-weight: bold;
      letter-spacing: 1px;
}
.submitbutton:hover {
      color: white;
      background-color: #282830;
      cursor: pointer;
}
input[type=checkbox] {
   margin:0px;padding:0px;
   margin-top:17px;
   margin-left:0px;
   width:14px;
   height:14px;
}
</style>



<center style="font-family:Roboto; font-size:40px;">View Results</center>

<br>
<br>
<br>

<div id="user"></div>

<div name="examlist" id="examlist" align="middle">
   <div class="col-md-7" style="float:center; width:50%; border-style:rounded;">
	<div class="panel panel-info">
	<div class="panel-heading"  style="background-color:#082759;">
	<div class="Bank"><center><font size="18px">Exam</font></center></div>
	</div>
	<div id="exams"></div>
	</div>
  </div>
 </div>
</div>

</div>
</div>
<br>
<br>
 <div class="button">
<center><button type="button" class="submitbutton" value="Submit" style="position: left;font-size: 20px;"onclick= "showGrades();">Submit</button>
</center>
  </div>

<script language='javascript'>

var length;
var LeftArr=[];
var RightArr=[];

var xhr = new XMLHttpRequest();


			xhr.onreadystatechange = function(){
						if(xhr.readyState == 4){
							var leftDisplay = document.getElementById('exams');
							var rightDisplay = document.getElementById('grades');

							var res=xhr.responseText;
							console.log(res);

							var data = JSON.parse(res);
							console.log(res);

							var len=data.length;
							legnth=len;
							console.log(len);

						var html="<div class='row'>";
							html+="<div class='col-md-7'>";
							html+="<table class='table table-striped' id='eTable'>";
							html+="<thead style='background-color:#0d365e; color:white;'><tr><th>Check</th>";

							html+='<th>Exam ID</th>';
							html+="<th>Exam Name</th>";


							html+="</tr></thead>";
							html+="<tbody>";


					for(var i=0;i<len;i++){

						LeftArr.push(data[i]['examid']);
						RightArr.push("grades"+data[i]['examid']);

						var examname = data[i]['examname'];
						var examid = data[i]['examid'];
						var combo = examid + "|" + examname;


						html+="<tr><td>";
						html+='<input type="checkbox" name="examlist" id="'+data[i]['examid'];
						html+='" value="'+combo+'"'+'></td>';

						html+='<td><br>'+data[i]['examid']+'</td>';
						html+='<td><br>'+data[i]['examname']+'</td>';

						html+='</tr>';
					}


		html+="</tbody></table>";
		html+="</div></div>";



		leftDisplay.innerHTML=html;

   }
}

xhr.open("POST","result_examlist.php", true);
var username = "<?php echo $_SESSION['username'];?>";
var myJSONobject={username:username}
xhr.send(JSON.stringify(myJSONobject));

function showGrades(){
		var xhr= new XMLHttpRequest();
		    xhr.onreadystatechange = function(){
					if(xhr.readyState == 4){



					  var res=xhr.responseText;
					  console.log(res);


						var Display = document.getElementById('examlist');

						var res=xhr.responseText;


						var data=JSON.parse(res);

						var len=data.length;

						var examid = data[1]['examid'];
						var examname = data[1]['examname'];
						var grade = data[1]['grade'];
						var html='<div class="containers">';



					html+='<br><br><h4><center><font size="+2">Exam name:'+examname+'</font></center></h4>';
					html+='<h4><center><font size="+2">Grade: '+grade+'</font></center></h4>';

          html+='</div>';



					Display.innerHTML=html;

        }
}

			var username = "<?php echo $_SESSION['username']; ?>";

			var chkbox=document.getElementsByName("examlist");


			for(var i=0;i<chkbox.length;i++){


					if(chkbox[i].checked){

							var examid=chkbox[i].id;
							var examdata=chkbox[i].value;

							var string = examdata.split("|");
							var examname = string[1];



							var sendarray = {username:username,examid:examid,examname:examname}

					}
				}
				console.log(sendarray);
				xhr.open("POST", "result_showgrade.php", true);
				xhr.send(JSON.stringify(sendarray));
}






</script>
