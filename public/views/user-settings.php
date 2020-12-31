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
        <p class="login-text">Update your profile.</p>
        <?php if(isset($messages)){
            foreach ($messages as $message)
                echo $message;
        }
        ?>
        <div class="input-rectangle">
            <form action="updateProfile" method="POST">
                <input type="text" name="name" value="<?= $user->getName() ?>" >
                <input type="text" name="login" value="<?= $user->getLogin() ?>" >
                <input type="password" name="password" placeholder="new password">
                <input type="password" name="password-confirm" placeholder="confirm password">
                <button type="submit" class="sign-up">SUBMIT</button>
            </form>
        </div>
    </div>

</body>

</html>