<?php 
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
            <div class="message">
                <span  onclick="this.parentElement.remove();">'.$message.'</span>
            </div>
            ';
        }
    }

    function formatar($n){
        return number_format($n, 2,',','.');
    }
    ?>

<style type="text/css">
    

.heading {
    padding: 10px 29px;
    font-size: 12px;
}
</style>
<header class="header">
    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="" class="bi bi-facebook"></a>
                <a href="" class="bi bi-twitter"></a>
                <a href="" class="bi bi-instagram"></a>
                <a href="" class="bi bi-linkedin"></a>
            </div>
            <p><a href="login.php">Login</a> | <a href="register.php">Registrar</a></p>
        </div>
    </div>
    <div class="header-2">
        <div class="flex">
        <a href="home.php" class="logo">Mambu&Paulina</a>
        <nav class="navbar">
            <a href="home.php">Início</a>
            <a href="about.php">Sobre</a>
            <a href="shop.php">Loja</a>
            <a href="contact.php">Contacto</a>
            <a href="orders.php">Pedidos</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="bi bi-list"></div>
            <a href="search_page.php" class="bi bi-search"></a>
            <div id="user-btn" class="bi bi-person-fill"></div>
            <?php
            $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            $cart_rows_number = mysqli_num_rows($select_cart_number);
            ?>
            
            
            <a href="cart.php"><i class="bi bi-cart-fill"></i><span>(<?php echo $cart_rows_number; ?>)</span></a>


            
        </div>
        <div class="user-box">
            <p>username: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email: <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Sair</a>
        </div>
        </div>
    </div>
</header>