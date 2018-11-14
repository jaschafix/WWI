<?php

session_start();
$product_ids = array();



//code voor shopping cart
//check of er op de knop is geklikt
if(filter_input(INPUT_POST, 'toevoegen')){
  if(isset($_SESSION['shopping_cart'])) {
//key tracker
    $count = count($_SESSION['shopping_cart']);

//genereed sequential array om id's te combineren
    $product_ids = $_SESSION['shopping_cart'];



    $added = false;

    for ($i = 0; $i < count($product_ids); $i++){
      if($product_ids[$i]["id"] == filter_input(INPUT_GET, 'StockItemID')) {
          $added = true;
          //quantity toevoegen aan bestaande product in de array
            $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
          }
      }




    if (!$added) {
    $_SESSION['shopping_cart'][$count] = array
      (
        'id' => filter_input(INPUT_GET, 'StockItemID'),
        'name' => filter_input(INPUT_POST, 'name'),
        'price' => filter_input(INPUT_POST, 'price'),
        'quantity' => filter_input(INPUT_POST, 'quantity')

      );
    }
    else { // product bestaat al, verhogen van de quantity
      //match array key aan de id van het toe te voegen product

      }
    }
  }
 else{ //als de array niet bestaat maak een array met value 0
  //maak een array met de submitted form data, gestart bij 0
  $_SESSION['shopping_cart'][0] = array
  (
    'id' => filter_input(INPUT_GET, 'StockItemID'),
    'name' => filter_input(INPUT_POST, 'name'),
    'price' => filter_input(INPUT_POST, 'price'),
    'quantity' => filter_input(INPUT_POST, 'quantity')
  );

 }

if(filter_input(INPUT_GET, 'action') == 'delete'){
  //loop door de shopping cart tot id is bereikt
  foreach($_SESSION['shopping_cart'] as $key => $product){
    if($product['id'] == filter_input(INPUT_GET, 'StockItemID')){
      unset($_SESSION['shopping_cart'][$key]);
    }
  }

  //reset session array keys om ze weer te matchen
  $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}



/* pre_r($_SESSION);
function pre_r($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}
*/
 ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Page Title</title>

    <?php include("includes/db_connection.php"); ?>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="cart.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Stores</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Your Account</a></li>
        <li><a href="shoppingcart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container">
  <?php
  include("includes/db_connection.php"); ?>
  <div class="row box">
  <?php
  $stmt = $pdo->prepare("SELECT StockItemName, RecommendedRetailPrice, SearchDetails, QuantityOnHand, i.StockItemID FROM stockitems i LEFT JOIN stockitemholdings h ON i.StockItemID = h.StockItemID LIMIT 99");
  $stmt->execute();
  $i = 1;
  while($row = $stmt->fetch())
  {
    $naam = $row["StockItemName"];
    $beschrijving = $row["SearchDetails"];
    $prijs = $row["RecommendedRetailPrice"];
    $voorraad = $row["QuantityOnHand"];
    $afbeelding = "images/placeholder.png";
    $productid = $row["StockItemID"]?>


<div class="col-sm-4" id="column" style=" flex: 1; margin-right: 10px; padding: 15px;" >
  <div class="panel">
    <div class="products">
<form method="post" action="index.php?action=add&StockItemID=<?php echo $productid ?>">

    <h6 class="panel-heading"><?php echo $naam ?></h6>
    <img src="images/placeholder.png" class="img-responsive">
    <h4>€ <?php echo $prijs ?></h4>
    <input type="number" name="quantity" min=1 oninput="validity.valid||(value='');">
    <input type="hidden" name="name" value="<?php echo $naam ?>">
    <input type="hidden" name="price" value="<?php echo $prijs ?>">
    <input type="submit" name="toevoegen" class="btn btn-info" value="toevoegen aan winkelmand" style="margin-bottom: 40px; margin-top: 5px">
  </div>
  </div>
</form>
</div>
<?php
            if($i % 3 === 0) echo "</div><div class='row box'>"; // close and open a div with class row

            $i++; // increment
        } ?>
</div>








</div>
</div>
</br>


</body>
</html>
