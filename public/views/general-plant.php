<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/plant.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
</head>

<body class="my-plants-container">
    <header>
        <div class="nav-desktop">
            <ul>
                <li><a id="home">home</a></li>
                <li><a id="discover">discover</a></li>
                <li><a id="myPlants">my plants</a></li>
                <?php if ($isSession) { ?>
                    <li><a id="signButton">sign out</a></li>
                <?php } else { ?>
                    <li><a id="signButton">sign in</a></li>
                <?php }; ?>
            </ul>
        </div>
        <div class="nav-bottom-mobile">

            <a id="myPlantsMobile"><i class="fas fa-seedling"></i>My Plants</a>
            <a id="addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a id="discover"><i class="fas fa-university"></i>Discover</a>

        </div>
    </header>
    <nav>
        <p class="my-plants-logo">gplant</p>
        <?php if ($isSession) { ?>
            <a id="addNewPlant" class="add-plant">
                <i class="fas fa-plus-circle"></i>
                <p class="desc">Add New Plant</p>
            </a>
        <?php }; ?>
        <a id="userSettings" class="settings">
            <i class="fas fa-cog"></i>
            <p class="desc">Settings</p>
        </a>
    </nav>
    <main>
        <div class="settings-back">
            <a id="mobileBack">
                <i class="fas fa-chevron-left"></i>
            </a>
            <i class="fas fa-cog"></i>
        </div>
        <div class="plant-desc">
            <p class="name-plant"><?= $plant['type'] ?></p>
        </div>
        <div class="general-plant-wrapper">

            <div class="plant-img">
                <img class="img-wrapper" src="public/uploads/<?= $plant['image'] ?>">
            </div>

        </div>
        <section class="plant-section">
            <h1>Description</h1>
            <p><?= $plant['main_description'] ?></p>
            <h1 class="water">Water</h1>
            <p><?= $plant['water_description'] ?></p>
        </section>

    </main>
</body>

</html>