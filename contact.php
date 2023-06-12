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
    <title>Contactos</title>

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
            <h3>Contacte-nos</h3>
            <p>Reclamações ou sertos problemas na página.
            </p>
        </div>
    </section>

    <section class="contact">
        <form action="" method="post">
            <h3>Hey diga alguma coisa!</h3>
            <input type="text" name="name" required placeholder="Insira o seu nome" class="box">
            <input type="email" name="email" required placeholder="Insira o seu email" class="box">
            <input type="number" name="number" required placeholder="Insira o seu numero" class="box">
            <textarea name="message" id="" cols="30" rows="10" placeholder="Insira a sua mensagem" required class="box"></textarea>
            <input type="submit" value="Enviar Mensagem" name="send" class="btn">
        </form>
    </section>


    <?php include 'footer.php'; ?>
    


    <script src="js/script.js"></script>
</body>
</html>