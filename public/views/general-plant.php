<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plant['type'] ?></title>
    <?php include('plant-head.php') ?>
</head>
<?php include('plant-header-nav.php') ?>

        <div class="plant-desc">
            <p class="name-plant"><?= $plant['type'] ?></p>
        </div>
        <div class="general-plant-wrapper">

            <div class="plant-img">
                <img class="img-wrapper" src="public/img/discover/<?= $plant['image'] ?>">
            </div>

        </div>
        <section class="plant-section">
            <h1>Description</h1>
            <?= $plant['main_description'] ?>
            <h1 class="water">Water</h1>
            <?= $plant['water_description'] ?>
        </section>

    </main>
</body>

</html>