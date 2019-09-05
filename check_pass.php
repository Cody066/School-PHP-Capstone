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
  $newPassword1=$_POST['newPassword1'];
  $newPassword1= mysqli_real_escape_string ($conn, $newPassword1);
  $newPassword2=$_POST['newPassword2'];
  $newPassword2= mysqli_real_escape_string ($conn, $newPassword2);
  
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
        if ($newPassword1 == $newPassword2) {

            $SQLString = "UPDATE admin_info SET password = '$newPassword1' 
            WHERE username = '$username' AND password = '$password'";
            $QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
                            mysqli_error(), E_USER_ERROR);
    
            mysqli_close($conn);
            header("Location:./view_categories.php");

        } else {
            echo "Passwords did not match";
        }


    header("Location:confirm_pass.php");

   } else {
     
     echo "Incorrect Password";
   }
   

?>