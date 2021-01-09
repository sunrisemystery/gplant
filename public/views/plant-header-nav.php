<body class="my-plants-container">
<header>
    <div class="nav-desktop">
        <ul>
            <li><a id="home">home</a></li>
            <li><a id="discover">discover</a></li>
            <li><a id="myPlants">my plants</a></li>
            <?php if ($isSession) { ?>
                <li><a id="signButton">sign out</a></li>
            <?php } else { ?>
                <li><a id="signButton">sign in</a></li>
            <?php }; ?>
        </ul>
    </div>
    <div class="nav-bottom-mobile ">

        <a id="myPlantsMobile"><i class="fas fa-seedling"></i>My Plants</a>
        <a id="addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
        <a id="discoverMobile"><i class="fas fa-university"></i>Discover</a>

    </div>
</header>
<nav>
    <p class="my-plants-logo">gplant</p>
    <?php if ($isSession) { ?>
        <a id="addNewPlant" class="add-plant">
            <i class="fas fa-plus-circle"></i>
            <p class="desc">Add New Plant</p>
        </a>
        <a id="userSettings" class="settings">
            <i class="fas fa-cog"></i>
            <p class="desc">Settings</p>
        </a>
    <?php }; ?>

</nav>
<main>
    <div class="settings-back">
        <a id="mobileBack">
            <i class="fas fa-chevron-left"></i>
        </a>
        <?php if ($isSession) { ?>
            <i id="settingsMobile" class="fas fa-cog"></i>
        <?php }; ?>
    </div>