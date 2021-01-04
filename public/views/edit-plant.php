<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plant</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/add-plant.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
</head>

<body class="add-plant-container">
    <header>
        <p class="logo-main">gplant</p>
        <nav>

            <div class="nav-desktop">
                <ul>
                    <li><a id="home">home</a></li>
                    <li><a id="discover">discover</a></li>
                    <li><a href="#">contact</a></li>
                    <li><a id="signButton">sign out</a></li>
                </ul>
            </div>
        </nav>
        <div class="nav-bottom-mobile">

            <a id="myPlants"><i class="fas fa-seedling"></i>My Plants</a>
            <a><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a id="discoverMobile"><i class="fas fa-university"></i>Discover</a>

        </div>
    </header>
    <main class="add-plant-main">
        <section class="form-section">
            <form class="add-plant-form" action="plant" method="POST" ENCTYPE="multipart/form-data">
                <div class="form-img">
                    <label class="label-img" for="file-input">
                        <i class="far fa-images"></i>
                        <p>PRESS TO CHANGE A FILE</p>
                    </label>
                    <input id="file-input" name="file" type="file">

                </div>
                <div class="form-text">
                    <?php if (isset($messages)) {
                        foreach ($messages as $message)
                            echo $message;
                    }
                    ?>
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

                </div>

            </form>
        </section>

    </main>
</body>

</html>