<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plant->getName() ?></title>
    <?php include('plant-head.php') ?>
    <script type="text/javascript" src="./public/js/waterNow.js" defer></script>
</head>
<?php include('plant-header-nav.php') ?>

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