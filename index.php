<?php
session_start();
include('db.php');
$status="";
if (isset($_POST['id']) && $_POST['id']!=""){
$id = $_POST['id'];
$result = mysqli_query($con,"SELECT * FROM `products` WHERE `id`='$id'");
$row = mysqli_fetch_assoc($result);
$name = $row['title'];
$id = $row['id'];
$price = $row['price'];
$image = $row['image'];

$cartArray = array(
	$id=>array(
	'name'=>$name,
	'id'=>$id,
	'price'=>$price,
	'quantity'=>1,
	'image'=>$image)
);

if(empty($_SESSION["shopping_cart"])) {
	$_SESSION["shopping_cart"] = $cartArray;
	$status = "<div class='box'>Product is added to your cart!</div>";
}else{
	$array_keys = array_keys($_SESSION["shopping_cart"]);
	if(in_array($id,$array_keys)) {
		$status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";	
	} else {
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
	$status = "<div class='box'>Product is added to your cart!</div>";
	}

	}
}
?>
<html>
<head>
<title>Shop</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">

<h2>Shop from here</h2>   

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div">
<a href="cart.php"><img src="cart-icon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($con,"SELECT * FROM `products`");
while($row = mysqli_fetch_assoc($result)){
		echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='id' value=".$row['id']." />
			  <div class='image'><img src='".$row['image']."' /></div>
			  <div class='name'>".$row['title']."</div>
		   	  <div class='price'>$".$row['price']."</div>
			  <button type='submit' class='buy'>Buy Now</button>
			  </form>
		   	  </div>";
        }
mysqli_close($con);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>

<br /><br />
</div>
</body>
</html>