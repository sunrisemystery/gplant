<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Plants</title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/my-plants.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
    <script type="text/javascript" src="./public/js/waterNow.js" defer></script>
</head>

<body class="my-plants-container">
    <header>
        <div class="nav-desktop">
            <ul>
                <li><a id="home">home</a></li>
                <li><a id="discover">discover</a></li>
                <li><a href="#">contact</a></li>
                <li><a id="signButton">sign out</a></li>
            </ul>
        </div>
        <div class="nav-bottom-mobile">

            <a><i class="fas fa-seedling"></i>My Plants</a>
            <a id="addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a id="discoverMobile"><i class="fas fa-university"></i>Discover</a>

        </div>
    </header>
    <nav>
        <p class="my-plants-logo">gplant</p>
        <a id="addNewPlant" class="add-plant">
            <i class="fas fa-plus-circle"></i>
            <p class="desc">Add New Plant</p>
        </a>
        <a id="settings" class="settings">
            <i class="fas fa-cog"></i>
            <p class="desc">Settings</p>
        </a>
    </nav>
    <main>
        <div class="info">
            <p class="my-plants">My Plants</p>
            <i id="settingsMobile" class="fas fa-cog"></i>
        </div>
        <div class="grid-wrapper">
            <?php
            if (isset($plants) && count($plants) > 0) {
                foreach ($plants as $plant) : ?>
                    <div class="square">
                        <form method="post" action="plant" class="inline">
                            <button type="submit" name="plant-id" value="<?= $plant->getId(); ?>" class="link-button">
                                <div class="plant-square">

                                    <img class="img-plant" src="public/uploads/<?= $plant->getImage() ?>">
                                    <div class="water-info">
                                        <i class="fas fa-tint"></i>
                                        <p class="<?= $plant->getId(); ?>"><?= $plant->countDays(); ?></p>
                                    </div>

                                </div>
                                <p class="plant-name"><?= $plant->getName() ?></p>
                            </button>
                        </form>

                        <p class="watering">Last watered <small><i class="fas fa-clock" id="<?= $plant->getId(); ?>"> <?= $plant->countDays() ?></i></small></p>


                        <button type="submit" name="water-now-button" class="button" value="<?= $plant->getId(); ?>">WATER NOW</button>


                    </div>
                <?php endforeach;
            } elseif (isset($messages) || count($plants) === 0) {
                ?>
                <p class="message">
                <?php
                foreach ($messages as $message)
                    echo $message;
            } ?>
                </p>


        </div>
    </main>
</body>

</html>