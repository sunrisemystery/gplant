<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Users' List</title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/discover-and-admin-panel.css">
    <script type="text/javascript" src="./public/js/adminPanel.js" defer></script>
    <script type="text/javascript" src="./public/js/popUp.js" defer></script>
</head>

<body class="display-container">
    <header>
        <p class="logo-main">gplant</p>
        <?php if ($isSession) { ?>
            <a href="/login" class="sign">sign out</a>
        <?php } else { ?>
            <a href="/login" class="sign">sign in</a>
        <?php } ?>
        <nav>
            <div class="nav-desktop">
                <ul>
                    <li><a href="/">home</a></li>
                    <li><a id="contact">info</a></li>
                    <li><a href="/discover">discover</a></li>
                    <?php if ($isSession) { ?>
                        <li><a href="/login">sign out</a></li>
                    <?php } else { ?>
                        <li><a href="/login">sign in</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <? include('components/pop-up-window.php') ?>
        <div class="img-discover-container">
            <p class="logo-mobile">gplant</p>
            <div class="main-img-discover"></div>
            <div class="img-text-d">
                <p>Welcome in Admin Panel. You can delete users' accounts there.</p>
            </div>
        </div>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input class="search-input" type="text" name="search" placeholder="SEARCH">
        </div>
        <div class="discover-list user-list">
            <?php foreach ($userList as $user) : ?>
                <div class="inline inline-height">
                    <div class="link-button add">
                        <div class="user-record">
                            <div class="record-text">
                                <strong><?= $user['login']; ?></strong>
                                <p><?= $user['email']; ?></p>
                                <p>Name: <?= $user['name']; ?></p>
                                <form method="post" action="adminView" class="delete-form">
                                    <button type="submit" class="delete-user" name="delete-user" id="<?= $user['id']; ?>" onclick="deleteUserConfirm(<?= $user['id']; ?> )">DELETE USER</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
<? include ('templates/user-template.php')?>

</html>