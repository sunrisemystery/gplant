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
                <li><a id="signButton">sign out</a></li>
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
        <div class="settings-back">
            <i class="fas fa-chevron-left"></i>
            <i class="fas fa-cog"></i>
        </div>
        <div class="plant-desc">
            <p class="name-plant"><?= $plant->getName() ?></p>
            <p class="plant-type"><?= $type['type'] ?></p>
        </div>
        <div class="plant-wrapper">

            <div class="plant-img">
            <img class="img-wrapper" src="public/uploads/<?= $plant->getImage() ?>">
            </div>
            <p class="watering-plant">Watering day </p>
            <div class="timer"><i class="fas fa-clock"> <?= $plant->countDays() ?></i></div>
            <button class="button-plant">WATER NOW</button>
        </div>
        <section class="plant-section">
            <h1>Water</h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Earum architecto voluptate nostrum alias voluptates beatae tempora iste iure officia eos ipsum amet, incidunt minima in qui deleniti id animi exercitationem impedit consequuntur ratione voluptatum totam tempore eius. Adipisci sed molestiae tempora autem ducimus amet facilis odit consequuntur illo vero nisi, ratione facere repellat laudantium, impedit commodi quasi laborum! Quod voluptatibus alias cupiditate molestias cumque quas veniam iste delectus distinctio reprehenderit, iusto nisi repudiandae eaque fugiat error. Alias provident natus voluptates ad labore accusamus voluptatibus saepe quos hic dicta. Aperiam laborum soluta voluptates beatae sint adipisci ad cupiditate blanditiis, necessitatibus suscipit nesciunt ab asperiores autem tempore ipsa enim officia aliquam qui? Provident quam omnis sed, nihil alias quaerat ut ea officia laudantium laborum itaque fugiat quia nobis rem delectus labore recusandae, inventore fuga aspernatur quis enim voluptatibus voluptatem doloribus deserunt? Ex voluptates minus adipisci reiciendis facilis placeat odio quo consequatur qui culpa dignissimos omnis fuga accusantium magni consequuntur exercitationem ab, facere, ut molestiae sapiente? Accusamus sed porro adipisci consectetur voluptas? A dicta alias, in minima voluptas quod? Mollitia, incidunt. Corporis error hic aliquid dolores facilis in impedit cum! Iure, et sequi? Veniam alias aperiam temporibus explicabo odio totam dolorem iste? Similique.</p>
        </section>
        <form method="post" action="myPlants" class="delete-form">
        <button type="submit" name="delete-plant"  class="delete-plant" onclick="deleteConfirm(<?= $plant->getId() ?>)" id="deleteButton">DELETE PLANT</button>
        </form>
    </main>
</body>

</html>