<?php include "insHead.php";?>
<?php session_start();?>
<style>

.col-md-4{
background-color:#dddddd;
		border-style:groove;
	border-width:7px;
	border-radius:8px;
}
.Bank {
font-family: "Roboto", sans-serif;
color: white;
}
input[type=checkbox] {
   margin:0px;padding:0px;
   margin-top:17px;
   margin-left:25px;
   width:14px;
   height:14px;
}
</style>
<center style="font-family:Roboto; font-size:40px;">Release Exam</center>
<br>
<br>


</div>
<div align="middle">
	
	<br><br>

		<div class="col-md-4" style="width:30%; border-style:rounded;">
				<div class="panel panel-info">
					<div class="panel-heading" style="background-color:#082759;">
						<div class=Bank><center><font size="18px;">Exam</font></center></div>
					</div>
					<div id="exams"></div>
				</div>
			</div>
	</div>
	
</div>

<div id="ajaxDiv"></div>
<br><br>




<script>

var xhr = new XMLHttpRequest();
var username = "<?php echo $_SESSION['username']; ?>";
var myobj={"username":username};
var length;


xhr.open("POST", "releaseExam_middle1.php", true);
xhr.send(JSON.stringify(myobj));

xhr.onreadystatechange = function(){
				
	if(xhr.readyState == 4 && xhr.status == 200){
	
	var return_data = xhr.responseText;
	console.log(return_data);
	
	
	var display = document.getElementById('exams');
	
	var data = JSON.parse(return_data);
	//console.log(data);
	
	var len=data.length;
	legnth=len;
	
		var html="<div class='row'>";
		html+="<div class='col-md-4'>";
		html+="<table class='table table-striped'>";
		html+="<thead style='background-color:#0d365e; color:white; font-size:18px;'><tr><th>Select</th>";

	
		html+="<th>Exam Name</th>";
		
		html+="</tr></thead>";
		html+="<tbody>";
	
		
		for(var i=0;i<len;i++){
			
			html+="<tr><td>";		
			html+=' <input type="checkbox" name="examlist" " value= " ' +data[i]['examname']+'"'+'></td>';
		

			
	
			html+='<td><br>'+data[i]['examname']+'</td>';
			
			
			
		}
	
	html+="</tbody></table>";
	html+="</div></div>";
 	html+='<br><br><center><input type="button" class="btn btn-primary" value="Release Exam" onclick="releaseExam();"></input></center>';
	display.innerHTML=html;
	
	
	}
				
}
			

function releaseExam(){
			var xhr;  
			try{xhr = new XMLHttpRequest();} 
			catch (e){try{xhr = new ActiveXObject("Msxml2.XMLHTTP");} 
			catch (e){try{xhr = new ActiveXObject("Microsoft.XMLHTTP");}
			catch (e){
			alert("BROWSER ERROR");
						}
					}
				}
				
				
				
			xhr.onreadystatechange = function(){
					if(xhr.readyState == 4){
					 
					  var res=xhr.responseText;
								console.log(res);
								
								var message='The exam' + examname +' has been released to the student.';
								alert(message);
								}
				}
			
			var username = "<?php echo $_SESSION['username']; ?>";
			var sendarray=[];
			sendarray.push({username:username});
			var check=document.getElementsByName("examlist");
			
			
			for(var i=0;i<check.length;i++){
					
					
					if(check[i].checked){
								
			  
							var examname=check[i].value;
							sendarray.push({examname:examname});
							
					}
				}
				console.log(sendarray);
				xhr.open("POST", "releaseExam_middle2.php", true); 
				xhr.send(JSON.stringify(sendarray));
}
</script>