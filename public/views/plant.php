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
    <script type="text/javascript" src="./public/js/waterNow.js" defer></script>
</head>

<body class="my-plants-container">
    <header>
        <div class="nav-desktop">
            <ul>
                <li><a id="home">home</a></li>
                <li><a id="discover">discover</a></li>
                <li><a id="myPlants">my plants</a></li>
                <li><a id="signButton">sign out</a></li>
            </ul>
        </div>
        <div class="nav-bottom-mobile">

            <a id="myPlantsMobile"><i class="fas fa-seedling"></i>My Plants</a>
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
        <div class="settings-back" id="myplantsBack">
            <i class="fas fa-chevron-left"></i>
            <i class="fas fa-cog"></i>
        </div>
        <div class="plant-desc">
            <p class="name-plant"><?= $plant->getName() ?></p>
            <p class="plant-type"><?= $data['type'] ?></p>
        </div>
        <div class="plant-wrapper">

            <div class="plant-img">
                <img class="img-wrapper" src="public/uploads/<?= $plant->getImage() ?>">
            </div>
            <p class="watering-plant">Last watered </p>
            <div class="timer"><i id="<?= $plant->getId(); ?>" class="fas fa-clock"> <?= $plant->countDays() ?></i></div>
            <div class="water-form">
                <button name="water-now-button" class="button-plant" value="<?= $plant->getId(); ?>">WATER NOW</button>
            </div>
        </div>
        <section class="plant-section">
            <h1>Water</h1>
            <p><?= $data['water_description'] ?></p>
        </section>
        <form method="post" action="editPlant" class="update-form">
            <button type="submit" name="update-plant" value="<?= $plant->getId(); ?>" class="update-plant" id="updateButton">EDIT PLANT</button>
        </form>
        <form method="post" action="myPlants" class="delete-form">
            <button type="submit" name="delete-plant" class="delete-plant" onclick="deleteConfirm(<?= $plant->getId() ?>)" id="deleteButton">DELETE PLANT</button>
        </form>

    </main>



</body>

</html>