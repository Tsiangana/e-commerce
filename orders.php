<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id']; 

if (!isset($user_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ourtos</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

<center>
    <h1 style="margin-top:18px;margin-bottom:18px;">COMPRA EFECTUADA</h1> 
</center>
 <style type="text/css">
    .vendas{ background: #c5dee996;
    border: 2px solid #bcbcbc;
    font-size: 18px;
    max-width: 677px;
    margin: 10px auto 33px;
    padding: 20px;
    line-height: 30px;
    border-radius: 6px;
    }
 </style>
 <?php
 if(isset($_SESSION['prdt'])){


 $total_products = $_SESSION['prdt'];
 $user_id = $_SESSION['user_id']; 
 $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE `total_products` = '{$total_products}' AND `user_id` = '{$user_id}'") or die ('query failed');
 ?>
        
            <?php
            while($dds = mysqli_fetch_assoc($order_query)){
                $stto = ($dds['payment_status'] == 'Pendente') ? '<span style="color:red;">'.$dds['payment_status'].'</span>': '<span style="color:#8e44ad;">'.$dds['payment_status'].'</span>';
            ?>
            <div class="vendas">
            <p>Data: <span style="color:#8e44ad"><?=$dds['placed_on']?></span>
            <br>Nome: <span style="color:#8e44ad"><?=$dds['name']?> </span>
            <br> Número: <span style="color:#8e44ad"><?=$dds['number']?></span>
            <br> Email: <span style="color:#8e44ad"><?=$dds['email']?></span>
            <br> Endereço: <span style="color:#8e44ad"><?=$dds['address']?></span>
            <br> Método de Pagamento: <span style="color:#8e44ad"><?=$dds['method']?></span>
            <br> Produtos: <span style="color:#8e44ad"><?=$dds['total_products']?></span>
            <br> Total a Pagar: <span style="color:#8e44ad">Kz <?=formatar($dds['total_price'])?></span>
            <br> Estado de Pagamento:  <?=$stto?> </p>
            </div>
            <?php

            }

             ?>
        
    <?php 

    unset($_SESSION['prdt']);
    }else{
        $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE `user_id` = '{$user_id}'") or die ('query failed');

            while($dds = mysqli_fetch_assoc($order_query)){
                $stto = ($dds['payment_status'] == 'Pendente') ? '<span style="color:red;">'.$dds['payment_status'].'</span>': '<span style="color:#8e44ad;">'.$dds['payment_status'].'</span>';
            ?>
            <div class="vendas">
            <p>Data: <span style="color:#8e44ad"><?=$dds['placed_on']?></span>
            <br>Nome: <span style="color:#8e44ad"><?=$dds['name']?> </span>
            <br> Número: <span style="color:#8e44ad"><?=$dds['number']?></span>
            <br> Email: <span style="color:#8e44ad"><?=$dds['email']?></span>
            <br> Endereço: <span style="color:#8e44ad"><?=$dds['address']?></span>
            <br> Método de Pagamento: <span style="color:#8e44ad"><?=$dds['method']?></span>
            <br> Produtos: <span style="color:#8e44ad"><?=$dds['total_products']?></span>
            <br> Total a Pagar: <span style="color:#8e44ad">Kz <?=formatar($dds['total_price'])?></span>
            <br> Estado de Pagamento:  <?=$stto?> </p>
            </div>
            <?php

            }

             
    }


    include 'footer.php'; 
    ?>
    


    <script src="js/script.js"></script>
</body>
</html>