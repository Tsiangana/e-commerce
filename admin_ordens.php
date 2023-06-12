<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'A fatura foi actualizada';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');  
    header('location:admin_ordens.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Outros Administradores</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

    <?php
    include 'admin_header.php';
    ?>

    <section class="orders">
        <h1 class="tittle">Facturas</h1>
        <div class="box-container">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {            
            ?>

            <div class="box">
                <p>user id : <span><?php echo $fetch_orders['user_id']; ?></span></p>
                <p>placed on : <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                <p>number : <span><?php echo $fetch_orders['number']; ?></span></p>
                <p>address : <span><?php echo $fetch_orders['address']; ?></span></p>
                <p>total price : <span><?php echo $fetch_orders['total_price']; ?>KZ</span></p>
                <p>payment method : <span><?php echo $fetch_orders['method']; ?></span></p>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                    <select name="update_payment" >
                        <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                        <option value="Pendente">Pendente</option>
                        <option value="Completo">Completo</option>
                    </select>
                    <input type="submit" value="Actualizar" name="update_order" class="option-btn">
                    <a href="admin_ordens.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">Apagar</a>
                </form>
            </div>
            <?php
                # code...
                }
            }else {
                echo '<p class="empty">No orders placed yet</p>';
            }
            ?>
        </div>
        
    </section>

    

    <script src="js/admin_script.js"></script>
</body>
</html>