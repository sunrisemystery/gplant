<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/login-and-register.css">
    <script type="text/javascript" src="./public/js/registerValidation.js" defer></script>
</head>

<body class="login-register">
    <div class="img-container"></div>
    <div class="login-container">
        <p class="logo">gplant</p>
        <p class="login-text">You can add additional information to your account later</p>
        <?php if (isset($messages)) {
            foreach ($messages as $message)
                echo $message;
        }
        ?>
        <div class="input-rectangle">
            <form action="register" method="POST">
                <input type="text" name="email" placeholder="email">
                <input type="text" name="login" placeholder="login">
                <input type="password" name="password" placeholder="password">
                <input type="password" name="password-confirm" placeholder="confirm password">
                <button type="submit" class="sign-up">SIGN UP</button>
            </form>
        </div>
    </div>

</body>

</html>