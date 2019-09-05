<?php

session_start();
include("../cms/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$DBConnect = mysqli_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
mysqli_select_db($db_name);


$sessID=session_id();
$_SESSION['user_id'] = $user_id;
$ip = $_SERVER['REMOTE_ADDR'];
$_SESSION['sessIP'] = $ip;

$Query = "SELECT * FROM cart_sessions WHERE session_id='$sessID'
AND IP ='$ip'";

$DuplicateCheck = mysqli_query($conn, $Query) or trigger_error( 
	mysqli_error(), E_USER_ERROR);

if (mysqli_num_rows($DuplicateCheck) > 0 ) { 
	 $errors=3; $is_duplicate="yes";
	}

$Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	

while ($Row = mysqli_fetch_assoc($Query_Result))

{
  $sessID = $Row["session_id"];
  $ip = $Row["IP"];
}

if ($sessID == session_id()) {

} else {
	$SQLString = "INSERT INTO cart_sessions (session_id , IP) 
						VALUES('$sessID', '$ip')";
		$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
					
	
}
   
?>
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View Items</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />

	</head>

	<body>
		<H1>View Items</h1>
		<table id = "catLeft">
<?php
	include("../cms/dbinfo.php");
	require '../SimpleImage-master/src/claviska/SimpleImage.php';
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
			// echo "  <td width=\"100\"> <a href ='itemsByCat.php'>$category</a></td>";
			 echo "  <td>\n";
			 echo "    <FORM action=\"itemsByCat.php\" method=\"POST\">\n";
			 echo "    <td><input type=\"submit\" name=\"submit\" value=\"$category\" /></td>";
			 echo "      <input type=\"hidden\" name=\"category_id\" value=\"$category_id\" />\n";
			 echo "    </FORM>\n";
			 echo "  </td>\n";
		  	 echo "  <td>\n";
	   }

	   
	if (!($conn)) {
	  die ("Connection failed: " . mysqli_connect_error());
	} 
	echo "<table id = 'items'>";
	echo "<tr>";
 	$TableName = "items";
	$QueryString = "SELECT * FROM $TableName ORDER BY description ASC";
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
		try {
		$imageThumb = new \claviska\SimpleImage();
		$imageThumb -> fromFile("../images/$image")
								-> bestFit(250,250);
		}catch(Exception $err){
			echo $err ->getMessage();
		}
		echo "  <FORM action = \"details.php\" method = \"POST\">\n";
		echo "  <td><input type = \"image\" src = \"../images/$image\"></td>";
		//echo "  <td><input type = \"image\"  src = \"$imageThumb\"></td>";
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

	mysqli_close($conn);
?>
		</table>
		

	</body>

</html>


<?php	


?>