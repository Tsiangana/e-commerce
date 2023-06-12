<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id']; 

if (!isset($user_id)) {
    header('location:login.php');
};
  
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST ['cart_id'];
    $cart_quantity = $_POST ['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity ='$cart_quantity' WHERE id ='$cart_id'") or die ('query failed');

    $message[] ='Quantidade do carrinho!';
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET ['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id ='$delete_id'") or die ('query failed');
    header('location:cart.php');
}
    
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id ='$user_id'") or die ('query failed');
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>

    <?php include 'header.php'; ?>
    <div class="heading" style="text-align: center; font-size: 3.5rem; margin-top: 30px;">
        <h3>Carrinho</h3>
        <p><a href="home.php">Home</a></p>
    </div>

    <!--<section class=""shopping-cart> -->

    
    <section class="products" >
    <h1 class="title"  style="margin-top:25px;margin-bottom:-10px">  Produtos Add</h1>
    <div class="box-container">
    <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_cart) > 0){
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)){ 
    ?>

    <div class="box">
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times"  onclick="return confirm('delete this from cart?');"></a>
          <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
          <div class="name"><?php echo $fetch_cart['name']; ?></div>                            
          <div class="price">kz<?php echo $fetch_cart['price']; ?></div>
          <form action="" method="post">
          <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
          <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
          <input type="submit" name="update_cart" value="update" class="option-btn">
          </form>
          <div class="sub-total" style="font-size: 2rem; padding-top: 1.5rem; color: var(--light-color);"> sub total : <span>kz<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?></span></div>
    </div>
    <?php
    $grand_total += $sub_total; 
     } 
    }else{
        echo '<p class="empty">seu carrinho está vazio</p>';
    }
    ?>
    </div>

        <div style="margin-top: 2rem; text-align:center;">
        <a href="cart.php?delete_all" class="delete-btn <?php echo($grand_total > 1)?
        '':'disabled'; ?>"   onclick="return confirm('delete all from cart?');">Apagar tudo </a>
    </div>

    <div class="cart-total">
    
    <div class="flex" style="text-align: center;">
        <a href="shop.php" class="option-btn">Ir as compras</a>
        <a href="checkout.php" class="btn <?php echo($grand_total > 1)?
        '':'disabled'; ?>">Proceder</a>
    </div> 
    <center>
      <p style="font-size: 20px;margin-top: 20px;">Total: <span><b>Kz <?php echo formatar($grand_total);?></b></span></p>  
    </center>
    
    </div>
    </section>

    <?php include 'footer.php'; ?>
    


    <script src="js/script.js"></script>
</body>
</html>