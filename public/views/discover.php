<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover</title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/discover-and-admin-panel.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
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
                    <?php if ($isSession) {
                        if (!$isAdmin) { ?>
                            <li><a href="/myPlants">my plants</a></li>
                        <?php } else { ?>
                            <li><a>discover</a></li>
                        <?php } ?>
                        <li><a href="/login">sign out</a></li>
                    <?php } else { ?>
                        <li><a>discover</a></li>
                        <li><a href="/login">sign in</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <?php if (!$isAdmin) { ?>
            <div class="nav-bottom-mobile">
                <a href="/myPlants"><i class="fas fa-seedling"></i>My Plants</a>
                <a href="/addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
                <a><i class="fas fa-university"></i>Discover</a>
            <?php } ?>
            </div>
    </header>
    <main>
        <? include('components/pop-up-window.php') ?>
        <div class="img-discover-container">
            <p class="logo-mobile">gplant</p>
            <div class="main-img-discover"></div>
            <div class="img-text-d">
                <p>Discover new plants, read more information about your favourites. Everything at one place.</p>
            </div>
        </div>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input class="search-input" type="text" name="search" placeholder="SEARCH">
        </div>
        <div class="discover-list">
            <?php foreach ($plantsList as $plant) : ?>
                <form method="post" action="generalPlant" class="inline">
                    <button type="submit" name="general-plant-id" value="<?= $plant['id'] ?>" class="link-button">
                        <div class="plant-record">
                            <div class="record-img">
                                <img class="plant-img" alt="<?= $plant['image'] ?>" src="public/img/discover/<?= $plant['image'] ?>">
                            </div>
                            <div class="record-text">
                                <strong><?= $plant['type'] ?></strong>
                                <p><?= substr($plant['main_description'], 0, 100) . '...'; ?></p>
                            </div>
                        </div>
                    </button>
                </form>
            <?php endforeach; ?>
        </div>
    </main>
</body>
<? include ('templates/discover-template.php') ?>

</html>