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
		<title>Delete Item Confirm</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<H1>Delete Item Confirm</h1>
		<h2>Are you sure you want to delete this item?</h2>
<?php

	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

	 $item_id=$_POST['item_id'];
	 $item_id= mysqli_real_escape_string ($conn, $item_id);

    $TableName = "items";
	$QueryString = "SELECT * FROM $TableName WHERE item_id='$item_id'";
	$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($Row = mysqli_fetch_assoc($QueryResult)) {
		$catdropdown = $Row["category"];
		$item_id = $Row["item_id"];
		$title = $Row["title"];
		$description = $Row["description"];
		$price = $Row["price"];
		$quantity = $Row["quantity"];
		$sku = $Row["sku"];
		$image = $Row["picture"];
	}   
	
?>
 			Category: 
<?php

	$sql = "select category_id, category from categories";
	$result = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($row = mysqli_fetch_assoc($result)) {
		$category_id = $row["category_id"];
		$category = $row["category"];						
		if($category_id == $catdropdown) echo "$category";
	}	
	echo "		<br /><br />";
   	echo "      Title: $title<br /><br />";
   	echo "      Description: $description<br /><br />";
   	echo "      Price: $price<br /><br />";
   	echo "      Quantity: $quantity<br /><br />";
   	echo "      SKU #: $sku<br /><br />";
   	echo "      Picture:<img src=\"../images/$image\" /><br /><br />";

 
	echo "<table><tr>";
    echo "  <td>";
    echo "  </td>";
    echo "  <td>\n";
    echo "    <FORM action=\"delete_item.php\" method=\"POST\">\n";
    echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
    echo "      <input type=\"submit\" name=\"submit\" value=\"CONFIRM\" />\n";
    echo "    </FORM>\n";
    echo "  </td>\n";
    echo "  <td>\n";
    echo "    <FORM action=\"view_items.php\" method=\"POST\">\n";
    echo "      <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
    echo "      <input type=\"submit\" name=\"submit\" value=\"GO BACK\" />\n";
    echo "    </FORM>\n";
    echo "  </td>\n";
    echo "</tr></table>";
	
    
	mysqli_close($conn);

?>

	</body>

</html>


<?php	
}
else {
	header("Location:../admin/login.php");
}

?>