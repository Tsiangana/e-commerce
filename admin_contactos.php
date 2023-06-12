<?php

include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');  
    header('location:admin_contactos.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Mensagens</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

    <?php
    include 'admin_header.php';
    ?>

    <section class="messages" >
    <h1 class="tittle">Mensagens</h1>
    <div class="box-container">
    <?php 
            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            if (mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                                
            ?>

            <div class="box">
                <p>Name: <span><?php echo $fetch_message['name']; ?></span></p>
                <p>Number: <span><?php echo $fetch_message['number']; ?></span></p>
                <p>Email: <span><?php echo $fetch_message['email']; ?></span></p>
                <p>Mensagem: <span><?php echo $fetch_message['message']; ?></span></p>
                <a href="admin_contactos.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Queres mesmo apagar essa mensagem?');" class="delete-btn">Apagar Mensagem</a>
            </div>

            <?php
                };
            }else {
                echo '<p class="empty">you have no message</p>';
            }   
            ?>
    </div>
    </section>

    

    <script src="js/admin_script.js"></script>
</body>
</html>