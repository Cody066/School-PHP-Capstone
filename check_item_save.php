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
    
	  $item_id=$_POST['item_id'];
	  $item_id= mysqli_real_escape_string ($conn, $item_id);
	  $catdropdown=$_POST['catdropdown'];
  	  $catdropdown= mysqli_real_escape_string ($conn, $catdropdown);
  	  $title=$_POST['title'];
	  $title= mysqli_real_escape_string ($conn, $title);
	  $description=$_POST['description'];
	  $description= mysqli_real_escape_string ($conn,  $description);
	  $price=$_POST['price'];
	  $price= mysqli_real_escape_string ($conn, $price);
	  $quantity=$_POST['quantity'];
	  $quantity= mysqli_real_escape_string ($conn, $quantity);
	  $sku=$_POST['sku'];
	  $sku= mysqli_real_escape_string ($conn, $sku);
	  $image= $_POST["fileToUpload"];
	  $image= mysqli_real_escape_string ($conn, $image);
	  $imageName = basename($_FILES[$image]['name']);
	  //$imageName= mysqli_real_escape_string ($conn, $imageName);
  
  	$errors = 0;
  
  	if ($item_id=="") $errors=1;
  	if ($title=="") $errors=2;
  	if ($description=="") $errors=3;
  	if ($price=="") $errors=4;
  	if ($quantity=="") $errors=5;
  	if ($sku=="") $errors=6;
  
	$TableName = "items";
	$sql = "SELECT * FROM $TableName WHERE title='$title' AND item_id!='$item_id'";
	$DuplicateCheck = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
	if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=7; $is_duplicate="yes"; }	  

	if ($errors>0) {

		$QueryString = "SELECT * FROM $TableName WHERE item_id='$item_id'";
		$QueryResult = mysqli_query($conn, $QueryString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
		while ($row = mysqli_fetch_assoc($QueryResult)) {
			$image = $Row["picture"];
 		}   
 ?>  
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Check Item Save</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>

		<h2>Enter Item Details Below</h2>
		<FONT color=red><h2>All Fields Are Required</h2></font>

   		<FORM action="check_item_save.php" method="POST"><input type="hidden" name="item_id" value="<?php echo "$item_id"; ?>" />
 	
			Category: <select name="catdropdown">
    						<option value = "">Choose a category</option>
<?php
   
		$sql = "SELECT category_id, category FROM categories";
		$result = mysqli_query($conn, $sql) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
		while ($row = mysqli_fetch_assoc($result)) {
			$category_id = $row['category_id'];
			$category = $row['category'];
			echo "<option value=\"$category_id\" ";
			if ($catdropdown==$category_id) echo " SELECTED ";
			echo ">$category\n";
		}
?>	
	 		</select>
			<?php if ($catdropdown=="") echo "<font color=red> *required</font>"; ?>
	 		<br /><br />
      		Title: 		<input type="text" name="title" value="<?php echo "$title"; ?>" />
			<?php if ($title=="") echo "<font color=red> *required</font>"; ?>
			<?php if ($title!="" && $is_duplicate=="yes") echo "<font color=red> *duplicate</font>"; ?>
      		<br /><br />
	  		Description : 	<input type="text" name="description" value="<?php echo "$description"; ?>" />
			<?php if ($description=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
			Price: 		<input type="text" name="price" value="<?php echo "$price"; ?>" />
			<?php if ($price=="") echo "<font color=red> *required</font>"; ?>
			<br /><br />
	  		Quantity:		<input type="text" name="quantity" value="<?php echo "$quantity"; ?>" />
			<?php if ($quantity=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
	  		SKU  : 			<input type="text" name="sku" value="<?php echo "$sku"; ?>" />
			<?php if ($sku=="") echo "<font color=red> *required</font>"; ?>
	  		<br /><br />
			Picture:<img src="../images/<?php echo "$image"; ?>" />
   		 	<br /><br />

      		<input type="submit" name="submit" value="Save" />
   		</FORM>

	</body>

</html>
<?php
		mysqli_close($conn);

  	} else {

		$SQLString = "UPDATE items SET category = '$catdropdown', title = '$title', description = '$description', price = '$price', quantity = '$quantity', sku = '$sku',
		picture = '$imageName'
		 WHERE item_id = '$item_id'";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);

		mysqli_close($conn);
		header("Location:./view_items.php");
	}

?>
  

  <?php	
}
else {
	header("Location:../admin/login.php");
}

?>

