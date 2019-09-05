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
$quantity=$_POST['quantity'];
$quantity= mysqli_real_escape_string ($conn, $quantity);


//mysqli_close($conn);

?>

<!DOCTYPE html PUBLIC " - //W3C//DTD XHTML 1.0	Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Cart</title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link href="css/styles.css" rel="stylesheet" type="text/css" />

	</head>

	<body>
		<H1>Cart</h1>
		<?php

include("../cms/dbinfo.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$DBConnect = mysqli_connect("localhost:8889", "root", "root") or die ("unable to connect".mysql_error());
mysqli_select_db($db_name);

echo "<table>";

    $Query = "SELECT shopping_cart.*, items.* FROM shopping_cart, items WHERE shopping_cart.item_id = items.item_id";
    $Query_Result = mysqli_query($conn , $Query) or trigger_error(mysqli_error(),E_USER_ERROR);	
    while ($Row = mysqli_fetch_assoc($Query_Result)){
        $sessID = $Row["session_id"];
        $ip = $Row["IP"];
        $cart_quantity = $Row["cart_quantity"];
        $item_id = $Row["item_id"];
        $title = $Row["title"];
        $price = $Row["price"];
        $subtotal += $price * $cart_quantity;

        echo "<tr>";
        echo "<FORM action = \"update_cart.php\" method = \"POST\">\n";
        echo "<td>$title</td>";
        echo "<td>$price $</td>";
        echo "<td>Quantity<input type=\"text\" name=\"cart_quantity\" value=\"$cart_quantity\"/></td>";
        echo "<input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
        echo "<td><input type=\"submit\" name=\"submit\" value=\"Update Cart\" /></td>\n";
        echo "</FORM>";
        echo "<FORM action = \"remove_item.php\" method = \"POST\">\n";
        echo "<input type=\"hidden\" name=\"item_id\" value=\"$item_id\" />\n";
        echo "<td><input type=\"submit\" name=\"submit\" value=\"Remove From Cart\" /></td>\n";
        echo "</FORM>";

    }
        echo "Subtotal : ";
        echo $subtotal;
        echo "$";
        ?>
	
		

	</body>
    <a href="items.php">Return To Main</a>
</html>