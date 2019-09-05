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

	$category_id=$_POST['category_id'];
    $category_id= mysqli_real_escape_string ($conn, $category_id);
    
    $category=$_POST['category'];
	$category= mysqli_real_escape_string ($conn, $category);
	
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
	
	$TableName = "categories";
	$QueryString = "SELECT * FROM $TableName WHERE category_id='$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$category = $Row["category"];
	}	
	
	if ($category!="") {
	
	$query = "DELETE FROM $TableName WHERE category_id = '$category_id'";
	$result = mysqli_query($conn, $query) or trigger_error( 
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