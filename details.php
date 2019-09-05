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
$Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	
while ($Row = mysqli_fetch_assoc($Query_Result))

{
  $sessID = $Row["session_id"];
  $ip = $Row["IP"];
}

if ($sessID = session_id) {

} else {
	$SQLString = "INSERT INTO cart_sessions (session_id , IP) 
						VALUES('$sessID', '$ip')";
	

	$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
						mysqli_error(), E_USER_ERROR);
					
	
}

	  $catdropdown=$_POST['catdropdown'];
	 
	  $title=$_POST['title'];
	 
	  $description=$_POST['description'];
	
	  $price=$_POST['price'];
	  
	  $quantity=$_POST['quantity'];
	
		$sku=$_POST['sku'];
		
		$item_id=$_POST['item_id'];
	
	  $image = $_POST['image'];
	  
      
    
?>      
      
<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>View Items</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />

	</head>

	<body>

    <table>
        <tr>
		<td> <img src = ../images/<?php echo "$image"; ?>></td>
		  <td><?php echo "$title";?></td>
		  <td><?php echo "$price";?></td>
          <td><?php echo "$catdropdown";?></td>
          <td><?php echo "$sku";?></td>
          <td><?php echo "$quantity";?></td>
					<td><?php echo "";?></td>
		<?php
	$sessID=session_id();

		echo "  <FORM action = \"cart.php\" method = \"POST\">\n";
		echo "  <input type=\"hidden\" name=\"sess\" value=\"$sessID\" />\n";
		echo "  <input type=\"hidden\" name=\"ip\" value=\"$ip\" />\n";
		echo "  <input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
		echo "  <input type=\"hidden\" name=\"quantity\" value= '1'  />\n";
		echo "  <input type=\"submit\" name=\"submit\" value=\"Add To Cart\" />\n";

		if (isset($item_id)){
			$Query = "SELECT * FROM cart_sessions WHERE session_id='$sessID'
			AND IP ='$ip'";
			$Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	
			while ($Row = mysqli_fetch_assoc($Query_Result))

					{
					$sessID = $Row["session_id"];
					$ip = $Row["IP"];
					}

			$Query = "SELECT * FROM shopping_cart WHERE item_id = '$item_id'";
			$DuplicateCheck = mysqli_query($conn, $Query) or trigger_error( 
				mysqli_error(), E_USER_ERROR);
			if ( mysqli_num_rows($DuplicateCheck) > 0 ) {  $errors=3; $is_duplicate="yes"; }	

			if ($sessID != "" && $errors == 0) {
					$SQLString = "INSERT INTO shopping_cart (session_id, IP, cart_quantity, item_id) 
					VALUES('$sessID', '$ip', 1, '$item_id')";

					$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
					mysqli_error(), E_USER_ERROR);

			} else {
					$SQLString = "INSERT INTO cart_sessions (session_id , IP) 
															VALUES('$sessID', '$ip')";
					$QueryResult = mysqli_query($conn, $SQLString) or trigger_error( 
															mysqli_error(), E_USER_ERROR);
													
			}
		}


		?>




		<tr>
    <table>      
    <a href="items.php">Return To Main</a>
    </body>

    </html>