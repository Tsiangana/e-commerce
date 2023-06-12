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

     $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE `payment_status` = 'Pendente'") or die ('query failed');
     function formatar($n){
        return number_format($n, 2,',','.');
    }
    ?>

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo"> Painel <span>Administrador</span></a>
        <nav class="nav_bar">
            <a href="admin_page.php">Início</a>
            <a href="admin_products.php">Produtos</a>
            <a href="admin_ordens.php">Ordens (<?=mysqli_num_rows($order_query)?>)</a>
            <a href="admin_users.php">Usuários</a>
            <a href="admin_contactos.php">Contactos</a>
        </nav>
        <div class="icons" style="display: flex;">
            <div id="user-btn" class="bi bi-user-fill"><i class="bi bi-person-fill"></i> </div>
            <div id="menu-btn" class="bi bi-bars" ><i class="bi bi-list"></i> </div>
        </div>
        <div class="account-box">
            <p>usuário: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Sair</a>
        </div>
    </div>
    
</header>