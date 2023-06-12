<?php 
include 'config.php';

if (isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email ='$email' AND password ='$pass'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $message[] = 'Este usuario ja existe !';
    }else{
        if ($pass != $cpass) {
            $message[] = 'Confirme a sua senha !';
        }else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES ('$name', '$email', '$cpass', '$user_type')") or die('busca falhou');
            $message[] = 'Registado com sucesso !';
            header('location:login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form_container{
            background-image: url('gift/fMIy7h.webp');
            background-repeat: no-repeat;
	        background-size: cover;
	        background-position: center;
        }
    </style>
</head>
<body>

    

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
    ?>

    <div class="form_container">
        
        <form action="" method="post">
            <h3>Cadastrar-se</h3>
            <input type="text" name="name" placeholder="Insira o seu none" required class="box">
            <input type="email" name="email" placeholder="email" required class="box">
            <input type="password" name="password" placeholder="senha" required class="box">
            <input type="password" name="cpassword" placeholder="confirma a sua senha" required class="box">
            <select name="user_type" class="box">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="Cadastrar" class="btn">
            <p>ja tenho uma conta ! <a href="login.php">fazer o login agora</a></p>
        </form>

    </div>
    
</body>
</html>