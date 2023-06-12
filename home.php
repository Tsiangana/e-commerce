<?php

include 'config.php';
session_start();

$user_id = $_SESSION['user_id']; 

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'ja foi adicionado ao carrinho';
    }else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'produto adicionado no carrinho';
    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .home{
        min-height: 60vh;
        background-image: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url('images/home.jpg');
        background-repeat: no-repeat;
	    background-size: cover;
	    background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <section class="home">
        <div class="content">
            <h3>Venha comprar os seus produtos</h3>
            <p>Bemvindo ao e-commerce Mambu e Paulina, um local onde você pode fazer a compra de seus produtos.
            </p>
                <a href="about.php" class="white-btn">Descubra mais...</a>
        </div>
    </section>

    <section class="products">
        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 4") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    # code...
            ?>
            <form action="" method="post" class="box">
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price"><?php echo $fetch_products['price']; ?>/kz</div>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="adicionar" name="add_to_cart" class="btn">
            </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">Ainda não foi adicionado nenhum produto!!!</p>';
                }
            ?>
        </div>
    </section>


    <?php include 'footer.php'; ?>
    


    <script src="js/script.js"></script>
</body>
</html>