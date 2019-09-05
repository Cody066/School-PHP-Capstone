<?php
/*
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
    */
?>
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View Items By Category</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />

	</head>

	<body>
		
    <?php

	include("../cms/dbinfo.php");

	$category_id=$_POST['category_id'];

	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	if (!($conn)) {
		die ("Connection failed: " . mysqli_connect_error());
	  } 
	echo "<table id = 'items'>";
	echo "<tr>";

	$TableName = "items";
	$QueryString = "SELECT * FROM $TableName WHERE category = '$category_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

	
	$counter = 0;	

	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$item_id = $Row["item_id"];
		$title = $Row["title"];
		$price= $Row["price"];
		$image = $Row["picture"];
		$catdropdown= $Row["category"];
		$quantity= $Row["quantity"];
		$sku= $Row["sku"];
	
	
		
		echo "  <FORM action = \"details.php\" method = \"POST\">\n";
		echo "  <td><input type = \"image\"  src = \"../images/$image\"></td>";
		echo "  <td><input type=\"submit\" name=\"submit\" value=\"$title\" /></td>";
		echo "  <td>$price</td>";
		echo "  <td>\n";
		echo "  <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
		echo "  <input type=\"hidden\" name=\"catdropdown\" value=\"$catdropdown\" />\n";
		echo "  <input type=\"hidden\" name=\"title\" value=\"$title\" />\n";
		echo "  <input type=\"hidden\" name=\"desription\" value=\"$description\" />\n";
		echo "  <input type=\"hidden\" name=\"price\" value=\"$price\" />\n";
		echo "  <input type=\"hidden\" name=\"sku\" value=\"$sku\" />\n";
		echo "  <input type=\"hidden\" name=\"image\" value=\"$image\" />\n";
		echo "  <input type=\"hidden\" name=\"quantity\" value=\"$quantity\" />\n";
   		echo "  <input type=\"submit\" name=\"submit\" value=\"Buy Now\" />\n";
		echo "  </FORM>\n";
		echo "  </td>\n";
		//echo "</tr>";
		   
		$counter ++;

		if ($counter == 3 || $counter == 6 || $counter ==9) {
			echo "</tr>";
			echo "<tr>";
		} else {}
		
   
 	}
	 echo "$category_id";
	mysqli_close($conn);

	
	?>

			</table>

		</body>
	
	</html>