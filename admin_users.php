<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');  
    header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Usuários</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

    <?php
    include 'admin_header.php';
    ?>

    <section class="users">
        <h1 class="tittle">Usuários</h1>
        <div class="box-container">
            <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('quer failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {                       
            ?>

            <div class="box">
                <p>USERNAME: <span><?php echo $fetch_users['name']; ?></span></p>
                <p>EMAIL: <span><?php echo $fetch_users['email']; ?></span></p>
                <p>USER TYPE: <span style="color:<?php if($fetch_users['user_type'] == 'admin'){echo 'var(--orange)';} ?>" ><?php echo $fetch_users['user_type']; ?></span></p>
                <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">Apagar</a>
                
            </div>

            <?php
            };
            ?>
        </div>
    </section>

    

    <script src="js/admin_script.js"></script>
</body>
</html>