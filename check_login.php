<?php
  //check login page

  session_start();
  include("../cms/dbinfo.php");
  $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  $DBConnect = mysqli_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
  mysqli_select_db($db_name);
  
  //retrieve username and password
  $username=$_POST['username'];
  $username= mysqli_real_escape_string ($conn, $username);
  $password=$_POST['password'];
  $password= mysqli_real_escape_string ($conn, $password);
  
  $user_id=0;

  $Query = "SELECT * FROM admin_info WHERE username ='$username'
  AND password ='$password' AND active='1'";
  $Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	
  while ($Row = mysqli_fetch_assoc($Query_Result))

  {
    $user_id = $Row["user_id"];
    $active = $Row["active"];
  }
  
   if ($active != 0  && $user_id != 0) {
   
		//SET user_id as session variable
		$_SESSION['user_id'] = $user_id;
		
		//generate unique session Id and set as session variable
		$sessID=session_id();
		$_SESSION['session_id'] = $sessID;
		
		$current_time = time();  //will give you # seconds since jan 1, 1970
		$current_date = date("Y-m-d"); //will give you 2012-01-16
				
    //send user_id and session id to DB
    $Query = "INSERT INTO current_sessions (session_id, user_id, last_visited, login_date) 
              VALUES ('$sessID','$user_id','$current_time','$current_date')";

    $Query_Result = mysqli_query($conn , $Query) or 
    trigger_error(mysqli_error(),E_USER_ERROR);	

    header("Location:../cms/index.html");

   } else {
     
     header("Location:./login.php");
   }
   

?>