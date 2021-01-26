<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Plant</title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/add-plant.css">
    <script type="text/javascript" src="./public/js/cancel.js" defer></script>
    <script type="text/javascript" src="./public/js/popUp.js" defer></script>
    <script type="text/javascript" src="./public/js/fileName.js" defer></script>
</head>

<body class="add-plant-container">
    <? include("components/edit-plant-header.php") ?>
    <main class="add-plant-main">
        <? include("components/pop-up-window.php") ?>
        <section class="form-section">
            <form class="add-plant-form" action="plant" method="POST" ENCTYPE="multipart/form-data">
                <div class="form-img">
                    <label class="label-img" for="file-input">
                        <i class="far fa-images"></i>
                        <p id="choose">PRESS TO CHANGE A FILE</p>
                    </label>
                    <input id="file-input" name="file" type="file">
                </div>
                <div class="form-text">
                    <p>
                        <?php if (isset($messages)) {
                            foreach ($messages as $message)
                                echo $message;
                        }
                        ?>
                    </p>
                    <input type="text" name="name" value="<?= $plant->getName() ?>">
                    <select name="selectType" class="select-class">
                        <option value="<?= $plantType["plant_id"] ?>">
                            <?php echo $plantType["type"]; ?>
                        </option>
                        <?php
                        foreach ($rowList as $val) {
                        ?>
                            <option value="<?= $val["id"] ?>">
                                <?php echo $val["type"]; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                    <button name="update-button" value="<?= $plant->getId() ?>" type="submit">UPDATE</button>
                    <a id="cancel" class="cancel">CANCEL</a>
                </div>
            </form>
        </section>
    </main>
</body>

</html>