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

<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
    
  	$category=$_POST['category'];
	$category_id=$_POST['category_id'];
	$category= mysqli_real_escape_string ($conn, $category);
	$category_id= mysqli_real_escape_string ($conn, $category_id);
  
  	$errors = 0;
  
  	if ($category_id=="") $errors=1;
  	if ($category=="") $errors=2;
  
	$TableName = "categories";
	$sql = "SELECT * FROM $TableName WHERE category='$category' AND category_id!='$category_id'";
	$DuplicateCheck = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=3; $is_duplicate="yes"; }	  

	if ($errors>0) {
?>  
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Check Category Save</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<FONT color=red><h2>All Fields Are Required</h2></font>
	   	<FORM action="check_category_save.php" method="POST">
	   		<input type="hidden" name="category_id" value="<?php echo "$category_id"; ?>" />
	      	Category: <input type="text" name="category" value="<?php echo "$category"; ?>" />
			<?php if ($category=="") echo "<font color=red> *required</font>"; ?>
			<?php if ($category!="" && $is_duplicate=="yes") echo "<font color=red> *duplicate</font>"; ?>
	      	<br><br>
	      	<input type="submit" name="submit" value="Save" />
	   	</FORM>

	</body>

</html>
<?php
		mysqli_close($conn);

  	} else {

		$SQLString = "UPDATE $TableName SET category='$category' WHERE category_id='$category_id'";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

		mysqli_close($conn);
		header("Location:./view_categories.php");
	}

?>
  

  <?php	
}
else {
	header("Location:../admin/login.php");
}

?>
