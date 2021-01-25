<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plant->getName() ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/plant.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
    <script type="text/javascript" src="./public/js/plant.js" defer></script>


</head>

<body class="my-plants-container">
    <?php include('components/plant-header-nav.php') ?>
    <main>
        <div class="settings-back">
            <a id="mobileBack">
                <i class="fas fa-chevron-left"></i>
            </a>
            <?php if ($isSession && !$isAdmin) { ?>
                <i id="settingsMobile" class="fas fa-cog"></i>
            <?php } ?>
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
            <div class="timer"><i class="fas fa-clock"></i>
                <p id="<?= $plant->getId(); ?>" class="days"><?= $plant->countDays() ?></p>
            </div>
            <div class="water-form">
                <button name="water-now-button" class="button-plant button-specify" value="<?= $plant->getId(); ?>">WATER NOW</button>
            </div>
        </div>
        <section class="plant-section">
            <h1>Water</h1>
            <?= $data['water_description'] ?>
        </section>
        <form method="post" action="editPlant" class="update-form">
            <button type="submit" name="update-plant" value="<?= $plant->getId(); ?>" class="update-plant button-specify" id="updateButton">EDIT PLANT</button>
        </form>
        <form method="post" action="myPlants" class="delete-form">
            <button type="submit" name="delete-plant" class="delete-plant" onclick="deleteConfirm(<?= $plant->getId() ?>)" id="deleteButton">DELETE PLANT</button>
        </form>
    </main>
</body>

</html>