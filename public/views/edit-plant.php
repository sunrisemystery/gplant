<!DOCTYPE html>
<html lang="en">
<? include ("edit-plant-head.php") ?>
<body class="add-plant-container">
<? include ("edit-plant-header.php") ?>
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
                    <a id="cancel" class="cancel">CANCEL</a>
                </div>

            </form>
        </section>

    </main>
</body>

</html>