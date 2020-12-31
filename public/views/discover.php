<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/discover.css">
    <script type="text/javascript" src="./public/js/buttonHandler.js" defer></script>
</head>

<body class="display-container">
    <header>
        <p class="logo-main">gplant</p>
        <nav>

            <div class="nav-desktop">
                <ul>
                    <li><a id="home">home</a></li>
                    <li><a id="discover">discover</a></li>
                    <li><a href="#">contact</a></li>
                    <?php if($isSession){ ?>
                        <li><a id="signButton">sign out</a></li>
                    <?php }else{ ?>
                        <li><a id="signButton">sign in</a></li>
                    <?php }; ?>
                </ul>
            </div>
        </nav>
        <div class="nav-bottom-mobile">

            <a id="myPlants"><i class="fas fa-seedling"></i>My Plants</a>
            <a id="addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a id="discoverMobile"><i class="fas fa-university"></i>Discover</a>

        </div>
    </header>
    <main>
        <div class="img-discover-container">
            <p class="logo-mobile">gplant</p>
            <div class="main-img-discover"></div>
            <div class="img-text-d">
                <p>Discover new plants, read more informations about your favourites. Everything at one place.</p>
            </div>
        </div>
        <form action="discover" method="post">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input  class="search-input" type="text" name="search" placeholder="SEARCH">
        </div>
        </form>
        <div class="discover-list">
            <?php foreach ($plantsList as $plant): ?>
            <form method="post" action="generalPlant" class="inline">
                <button type="submit" name="general-plant-id" value="<?= $plant['id'] ?>" class="link-button">
        <div class="plant-record">
            <div class="record-img">
            <img class="plant-img" src="public/uploads/<?= $plant['image'] ?>">
            </div>
            <div class="record-text">
                <strong><?= $plant['type']; ?></strong>
                <p><?= substr($plant['main_description'],0,100).'...'; ?></p>
            </div>
        </div>
                </button>
            </form>
            <?php endforeach;?>

        </div>

    </main>
</body>

</html>