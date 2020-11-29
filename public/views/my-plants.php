<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Plants</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/my-plants.css">
</head>

<body class="my-plants-container">
    <header>
        <div class="nav-desktop">
            <ul>
                <li><a href="#">home</a></li>
                <li><a href="#">discover</a></li>
                <li><a href="#">contact</a></li>
                <li><a href="public/views/login.html">sign out</a></li>
            </ul>
        </div>
        <div class="nav-bottom-mobile">

            <a href="#"><i class="fas fa-seedling"></i>My Plants</a>
            <a href="#"><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a href="#"><i class="fas fa-university"></i>Discover</a>

        </div>
    </header>
    <nav>
        <p class="my-plants-logo">gplant</p>
        <a href="" class="add-plant">
            <i class="fas fa-plus-circle"></i>
            <p class="desc">Add New Plant</p>
        </a>
        <a href="" class="settings">
            <i class="fas fa-cog"></i>
            <p class="desc">Settings</p>
        </a>
    </nav>
    <main>
        <div class="info">
            <p class="my-plants">My Plants</p>
            <i class="fas fa-cog"></i>
        </div>
        <div class="grid-wrapper">
            <div class="square">
                <a href="#" class="click-plant">
                    <div class="plant-square">

                        <img class="img-plant" src="public/uploads/<?= $plant->getImage() ?>">
                        <div class="water-info">
                            <i class="fas fa-tint"></i>
                            <p>11 days</p>
                        </div>

                    </div>
                    <p class="plant-name"><?= $plant->getName() ?></p>
                </a>
                <p class="watering">Watering day <small><i class="fas fa-clock"> 11 days</i></small></p>
                <a class="button" href="#">WATER NOW</a>
            </div>
            <div class="square">
                <a href="#" class="click-plant">
                    <div class="plant-square">
                        <img class="img-plant" src="public/img/cactus.jpg">
                        <div class="water-info">
                            <i class="fas fa-tint"></i>
                            <p>11 days</p>
                        </div>
                    </div>
                    <p class="plant-name">John</p>
                </a>
                <p class="watering">Watering day <small><i class="fas fa-clock"> 11 days</i></small></p>
                <a class="button" href="#">WATER NOW</a>
            </div>
            <div class="square">
                <a href="#" class="click-plant">
                    <div class="plant-square">
                        <img class="img-plant" src="public/img/cactus.jpg">
                         <div class="water-info">
                        <i class="fas fa-tint"></i>
                        <p>11 days</p>
                    </div></div>
                    <p class="plant-name">John</p>
                </a>
                <p class="watering">Watering day <small><i class="fas fa-clock"> 11 days</i></small></p>
                <a class="button" href="#">WATER NOW</a>
            </div>
            <div class="square">
                <a href="#" class="click-plant">
                    <div class="plant-square">
                        <img class="img-plant" src="public/img/cactus.jpg">
                        <div class="water-info">

                        <i class="fas fa-tint"></i>
                        <p>11 days</p>
                    </div></div>
                    <p class="plant-name">John</p>
                </a>
                <p class="watering">Watering day <small><i class="fas fa-clock"> 11 days</i></small></p>
                <a class="button" href="#">WATER NOW</a>
            </div>
            <div class="square">
                <a href="#" class="click-plant">
                    <div class="plant-square">
                        <img class="img-plant" src="public/img/cactus.jpg">
                        <div class="water-info">

                        <i class="fas fa-tint"></i>
                        <p>11 days</p>
                    </div></div>
                    <p class="plant-name">John</p>
                </a>
                <p class="watering">Watering day <small><i class="fas fa-clock"> 11 days</i></small></p>
                <a class="button" href="#">WATER NOW</a>
            </div>
        </div>
    </main>
</body>

</html>