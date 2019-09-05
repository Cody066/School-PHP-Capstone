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
		<title>View Categories</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
		<H1>View Categories</h1>
		<TABLE>
<?php
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

	$TableName = "items";
	$QueryString = "SELECT * FROM $TableName";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$categoryItems = $Row["category"];

	}

 	$TableName = "categories";
	$QueryString = "SELECT * FROM $TableName ORDER BY category ASC";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
   		$category = $Row["category"];
   		$category_id = $Row["category_id"];
		


   		echo "<tr>";
   		echo "  <td width=\"100\">$category</td>";
   		echo "  <td>\n";
   		echo "    <FORM action=\"edit_category.php\" method=\"POST\">\n";
   		echo "      <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />\n";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"EDIT\" />\n";
   		echo "    </FORM>\n";
   		echo "  </td>\n";
		echo "  <td>\n";

		if ($category_id <> $categoryItems) {
		
		echo "    <FORM action=\"delete_category_confirm.php\" method=\"POST\">\n";
   		echo "      <input type=\"hidden\" name=\"item_id\" value=\"$category_id\" />\n";
   		echo "      <input type=\"submit\" name=\"submit\" value=\"DELETE\" />\n";
   		echo "    </FORM>\n";
   		echo "  </td>\n";
   		echo "</tr>";
		}
		else {
			
		}
 	}

	mysqli_close($conn);
?>
		</table>
		<br /><a href="index.html">Return To Main</a>

	</body>

</html>


<?php	
}
else {
	header("Location:../admin/login.php");
}

?>