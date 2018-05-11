<style>

 .login-page {
          width: 360px;
          padding: 8% 0 0;
          margin: auto
        }
        .form {
          position: relative;
          background: #FFFFFF;
          max-width: 360px;
          margin: 0 auto 140px;
          padding: 45px;
          text-align: center;
         }
        .form input {
          font-family: "Roboto", sans-serif;
          outline: 0;
          background: #f2f2f2;
          width: 100%;
          border: 0;
          margin: 0 0 15px;
          padding: 15px;
          box-sizing: border-box;
          font-size: 14px;
        }
        .form button {
          font-family: "Roboto", sans-serif;
          outline: 0;
          background: #082759;
           width: 100%;
          border: 0;
          padding: 15px;
          color: #FFFFFF;
          font-size: 14px;
          cursor: pointer;
        }

        body {
          background: #082759;
          font-family: "Roboto", sans-serif;

        }


</style>



<head>
        <meta charset="utf-8">
</head>


<body>

   <div class="login-page">

    <img src="https://upload.wikimedia.org/wikipedia/commons/2/21/NJIT_Athletics_wordmark.png" height="80">

  <div class="form">

    <form class="login-form">
      <div>
      Username:<input type="text" id='Username'/>
      Password:<input type="password" id='Password' onkeypress='enterKey(event)'/>
      </div>
       <button type= "button" onclick ='send()'>LOGIN</button>
    </form>



  </div>
</div>
     <div id="send"></div>

<script language="javascript">
 //create key-value object pairs, send data to file using Ajax 
function send(){

    var username = document.getElementById('Username').value;
    var password = document.getElementById('Password').value;
    
    var data = "ucid="+username+"&pass="+password;

    var hr = new XMLHttpRequest();
    hr.onreadystatechange = function() 
    {
       if(hr.readyState == 4) 
       {

          var return_data = hr.responseText;
          console.log(return_data);

          var obj = JSON.parse(return_data);
          console.log(obj);

          if(obj['login']=="student") 
          {
            window.location.replace("stuFront.php");
          }
          else if(obj['login']=="teacher") 
          {
            window.location.replace("insFront.php");
          }
          else 
          {
            document.getElementById("status").innerHTML = "login failed";
          }
      }

   }
   
   hr.open("POST", "logintest.php" , true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");


      hr.send(data);



}

//user can press 'Enter' instead of clicking 'Login'
function enterKey(e)
{
   e.which = e.which || e.keyCode;
     if(e.which == 13)
     {
            send();
     }
}



  </script>
</body>

