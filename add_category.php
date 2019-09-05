<?php

session_start();
include("dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$DBConnect = mysqli_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
mysqli_select_db($db_name);

//retrieve username and password
$username=$_POST['username'];
$username= mysqli_real_escape_string ($conn, $username);
$password=$_POST['password'];
$password= mysqli_real_escape_string ($conn, $password);

$sessID=session_id();
$_SESSION['user_id'] = $user_id;

$Query = "SELECT * FROM current_sessions WHERE session_id='$sessID'
AND user_id='$user_id'";
$Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	
while ($Row = mysqli_fetch_assoc($Query_Result))

{
  $sessID = $Row["session_id"];
  $user_id = $Row["user_id"];
}

if ($sessID = session_id) {
?>
	<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	
		<head>
			<title>Add A Category</title>
			<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		</head>
	
		<body>
	
			<h2>Enter A New Category</h2>
	
			   <FORM action="check_category_add.php" method="POST">
				 Category: <input type="text" name="category" value="" /><br /><br />
				  <input type="submit" name="submit" value="Save" />
			   </FORM>
	
			<a href="index.html">Return To Main</a>   
	   
		</body>
	
	</html>
<?php	
}
else {
	header("Location:../admin/login.php");
}

?>








