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


$item_id=$_POST['item_id'];
$item_id= mysqli_real_escape_string ($conn, $item_id);
$cart_quantity=$_POST['cart_quantity'];
$quantity= mysqli_real_escape_string ($conn, $quantity);



$Query = "UPDATE shopping_cart SET cart_quantity = '$cart_quantity' WHERE item_id = '$item_id'";
$Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	

header("Location:cart.php");

?>