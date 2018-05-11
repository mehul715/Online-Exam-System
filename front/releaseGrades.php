<?php include "mid.php";?>
<?php include "insHead.php";?>
<?php session_start();?>
<style>

 /*.column{
background-color:#dddddd;
		border-style:groove;
	border-width:7px;
	border-radius:8px;
}*/
.Bank {
font-family: "Roboto", sans-serif;
color: white;
}
input[type=checkbox] {
   margin:0px;padding:0px;
   margin-top:17px;
   margin-left:0px;
   width:14px;
   height:14px;
   transform: scale(1.5);
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
    color: white;
}
    

</style>

<br>
<br>
<br>
<br>
<br>

</div>
<div align="middle">

	<div class="row">
		<div class="column" style="float:center; width:50%; border-style:rounded;">
				<div class="panel panel-info">
					<div class="panel-heading"  style="background-color:#082759;">
					<div class="Bank"><center><font size="18px;">Release Grades</font></center></div>
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
var length;
var finalarray =[];

xhr.onreadystatechange = function(){

  if(xhr.readyState == 4){
      var res=xhr.responseText;
      console.log(res);

      var Display = document.getElementById('exams');

      var res=xhr.responseText;
		   console.log(res);
     var data=JSON.parse(res);
  console.log(data);

						var len=data.length;


            	var html="<div class='row'>";
		html+="<div class='column'>";
		html+="<table class='table table-striped'>";
    html+="<table id='review'>";
		html+="<thead style='background-color:#42ABCA'; color:white;'><tr><th>Check</th>";

    html+="<th>Exam ID</th>";
    html+="<th>Exam name</th>";
    html+="<th>Graded</th>";

		html+="</tr></thead>";
		html+="<tbody>";



        for(var i=1;i<len;i++){


			html+="<tr><td>";
			html+='<input type="checkbox" class="pretty" name="examlist" onclick="onlyOne(this)" id="'+data[i]['exam_id'];
			html+=' " value= "' +data[i]['examname']+'"'+'></td>';

      if(data[i]['grade'] == ''){
        var check ='<p>&#10060;</p>';
      }
      else {
        var check='<p>&#9989;</p>';
      }

      html+='<td><br>'+data[i]['exam_id']+'</td>';
      html+='<td><br>'+data[i]['examname']+'</td>';
      html+='<td>'+check+'</td>';
       }

       	html+="</tbody></table>";
        html+="</div></div>";
        html+='<br><br><input type="button" class="submitbutton" value="Release Grades" onclick="releasegrades();"/>';
	     Display.innerHTML=html;

   }
}

var username = "<?php echo $_SESSION['username']; ?>";
var myobj={"username":username};

xhr.open("POST", "releaseGrades_examlist.php", true);
xhr.send(JSON.stringify(myobj));


function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('examlist')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

function releasegrades(){

var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
					  var res=xhr.responseText;
		        console.log(res);
            var message='The exam' + examname +' has been released.';
		        alert(message);
        }
  }

var username = "<?php echo $_SESSION['username']; ?>";
var sendarray=[];
sendarray.push({username:username});

var check = document.getElementsByName("examlist");

for ( var index = 0; index < check.length; index++) {
     if(check[index].checked) {
         //console.log(check[index]);
         var exam_id=check[index].id;
         var examname=check[index].value;
        
         sendarray.push({exam_id:exam_id,examname:examname});
     }
}
        //console.log(sendarray);
xhr.onreadystatechange = function(){
if(xhr.readyState == 4){
   window.location.assign("releaseSubmitted.php");
  }
};
    xhr.open("POST", "releaseGrades_updateexam.php", true);
    console.log(JSON.stringify(sendarray));
    xhr.send(JSON.stringify(sendarray));

}

</script>
