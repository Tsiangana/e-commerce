<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id']; 

if (!isset($user_id)) {
    header('location:login.php');
}
if (isset($_POST['order-btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number= $_POST['number'];
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, 'Endereço '. $_POST['street'].', '. $_POST['city'].','.$_POST['country']);

    $placed_on = date('d-m-Y'); 
    $cart_total = 0;
    $cart_products []= '';

     $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id") or die('query failed');
     if(mysqli_num_rows($cart_query) > 0){
        while ($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products []= $cart_item ['name'] .'('.$cart_item ['quantity'].')';
            $sub_total = ($cart_item ['price'] * $cart_item ['quantity']);
            $cart_total += $sub_total;
        }
    }
    //valor total da venda $cart_total;
    
    $total_products = mysqli_num_rows($cart_query);
    $total_products = implode(',', $cart_products);
    $total_products = ltrim($total_products,',');
    //"Produtos e suas qtd: ".$total_products;

    
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE `name` = '{$name}' AND `number` = '{$number}' AND `email` ='{$email}' AND `method` = '{$method}' AND `address` ='{$address}' AND `total_products` = '{$total_products}' AND `total_price` = '{$cart_total}'") or die ('query failed');
    
    
    if($cart_total == 0){
        $message[] = 'Seu carrinho está vazio';


    }else{

        if(mysqli_num_rows($order_query) > 0){
            $message[]= 'Compra já foi feita';

        }else{
        $add = mysqli_query($conn, "INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES (NULL, '{$user_id}', '{$name}', '{$number}', '{$email}', '{$method}', '{$address}', '{$total_products}', '{$cart_total}', '{$placed_on}', 'Pendente')") or die ('query failed');
        if($add){
            $dll = mysqli_query($conn, "DELETE FROM cart WHERE `cart`.`user_id` = {$user_id}");
            $_SESSION['sms']= 'Compra efectuada com sucesso';
            $_SESSION['prdt'] = $total_products;
            header("Location:orders.php");
        }else{
            $_SESSION['sms']= 'Não foi possível efectuar a compra. Tente novamente';
        }
        
        //mysqli_query($conn, "INSERT INTO * FROM `orders` (name,number,email, method, address, total_products, total_price, placed_on) VALUES($name','$number' ,'$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die ('query failed'); 
        
        }
    }   
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checado</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style type="text/css">
    table{
        font-size: 17px;
    }
    th{
        padding: 9px;
    }
    td{
            border-bottom: 1px solid #ddd;
             padding: 9px;
    }
</style>
    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>checkout</h3>
        <p><a href="home.php">Home</a>/ checkout</p>
    </div>

    <section class="display-order">
        <table style="width: 100%;border: 1px solid #ddd;">
        <thead style="background: #000;color: #fff;">
             <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Preço</th>
                <th>Subtotal</th>
            </tr>   
        </thead>
        <tbody>
    <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_cart) > 0){
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
       
    
    ?>
    
            <tr>
                <td><?php echo $fetch_cart['name']?></td>
                <td><?php echo $fetch_cart['quantity'];?></td>
                <td><?php echo 'Kz '. formatar($fetch_cart['price']);?></td>
                <td><?php echo 'Kz '. formatar($fetch_cart['quantity'] * $fetch_cart['price']);?></td>
            </tr>
       
    <!--<p> <span>(.'/-'.'x'. )</span></p>-->
    <?php
     }
    }else{
        echo '<tr><td colspan="3">seu carrinho está vazio</td></tr>';
    }
    
    ?>
 </tbody>
    </table>
    <div class="grand-total"> Total :  <span>Kz <?php echo  formatar($grand_total);?></span></div>
    </section>

    <section class="checkout">

    <form action="checkout.php" method="post">
    <h3>Informações para compra</h3>
    <div class="flex"> 
        <div class="inputbox">
            <span>Seu nome :</span>
            <input type="text" name="name" required placeholder="insira seu nome">
        </div>
        <div class="inputbox">
            <span>Seu número :</span>
            <input type="number" name="number" required placeholder="insira seu número">
        </div>
        <div class="inputbox">
            <span>Seu email :</span>
            <input type="email" name="email" required placeholder="insira seu email">
        </div>
        <div class="inputbox">
            <span>Método de pagamento :</span>
            <select name="method">
                <option value="Pagamento na entrega">Pagamento na Entrega</option>
                <option value="Cartão">Cartão</option>
            </select>
        </div>
        <div class="inputbox">
        <span>País:</span>
        <input type="text" name="country" required placeholder="insira sua província">
    </div>
        <div class="inputbox">
        <span>Província</span>
        <input type="text" name="state" required placeholder="insira sua província">
    </div>

    
        <div class="inputbox">
            <span>Endereço:</span>
            <input type="text" name="street" required placeholder="insira sua província">
        </div>
        <div class="inputbox">
            <span>Cidade:</span>
            <input type="text" name="city" required placeholder="insira sua cidade">
        </div>

        
    </div>
    <input type="submit" value="Pagar agora" class="btn" name="order-btn">
    </form>

    </section>

    

    <?php include 'footer.php'; ?>
    


    <script src="js/script.js"></script>
</body>
</html>