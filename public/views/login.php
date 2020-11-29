<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/login-and-register.css">
</head>

<body class="login-register">
    <div class="img-container"></div>
    <div class="login-container">
        <p class="logo">gplant</p>
        <p class="login-text">Taking care of plants is our priority. Join us today to give your plants better life.</p>
        <div class="messages">
            <?php if(isset($messages)){
                foreach ($messages as $message)
                echo $message;
            }
            ?>
        </div>
        <div class="input-rectangle">
            <form action="login" method="post">
                <input type="text" name="login" placeholder="login">
                <input type="password" name="password" placeholder="password">
                <button class="sign-in">SIGN IN</button>
                <p>Don't have account?</p>
                <button type="submit" class="sign-up">SIGN UP</button>
            </form>
        </div>
    </div>

</body>

</html>