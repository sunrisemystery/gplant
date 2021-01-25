<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plant->getType() ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/plant.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
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
            <p class="name-plant"><?= $plant->getType() ?></p>
        </div>
        <div class="general-plant-wrapper">
            <div class="plant-img">
                <img class="img-wrapper" src="public/img/discover/<?= $plant->getImage() ?>">
            </div>
        </div>
        <section class="plant-section">
            <h1>Description</h1>
            <?= $plant->getMainDescription() ?>
            <h1 class="water">Water</h1>
            <?= $plant->getWaterDescription() ?>
        </section>
    </main>
</body>

</html>