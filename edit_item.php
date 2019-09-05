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
		<title>Edit Item</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
	</head>

	<body>
		<H1>Edit Item</h1>

<?php

	 $item_id=$_POST['item_id'];
	 $item_id= mysqli_real_escape_string ($conn, $item_id);
  
	include("dbinfo.php");
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 

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
	 	<FORM action="check_item_save.php" method="POST"><input type="hidden" name="item_id" value="<?php echo "$item_id"; ?>" />
 			Category: <select name="catdropdown">
					<option value = "">Select a category:</option>
<?php

	$sql = "SELECT category_id, category FROM categories";
	$result = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	while ($row = mysqli_fetch_assoc($result)) {
		$category_id = $row["category_id"];
		$category = $row["category"];
		echo "<option value=\"$category_id\" ";							
		if($category_id == $catdropdown) echo "SELECTED ";
		echo ">$category</option>";
	}	
	echo "</select><br /><br />";
   	echo "      Title:<input type=\"text\" name=\"title\" value=\"$title\" /><br /><br />";
   	echo "      Description:<textarea type=\"text\" name=\"description\" value=\"$description\" ></textarea><br /><br />";
   	echo "      Price:<input type=\"text\" name=\"price\" value=\"$price\" /><br /><br />";
   	echo "      Quantity::<input type=\"text\" name=\"quantity\" value=\"$quantity\" /><br /><br />";
   	echo "      SKU #:<input type=\"text\" name=\"sku\" value=\"$sku\" /><br /><br />";
   	echo "      Picture:<img src=\"../images/$image\" /><br /><br />";
   	echo "      <input type=\"submit\" name=\"submit\" value=\"Save\" />";

	mysqli_close($conn);
 
?>
		</FORM>

	</body>

</html>


<?php	
}
else {
	header("Location:../admin/login.php");
}

?>