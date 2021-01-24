<header>
    <div class="nav-desktop">
        <ul>
            <li><a href="/">home</a></li>
            <li><a href="/discover">discover</a></li>
            <?php if ($isAdmin) { ?>
                <li><a href="/adminView">admin panel</a></li>
            <?php } else { ?>
                <li><a href="/myPlants">my plants</a></li>
            <?php } ?>
            <?php if ($isSession) { ?>
                <li><a href="/login">sign out</a></li>
            <?php } else { ?>
                <li><a href="/login">sign in</a></li>
            <?php } ?>
        </ul>
    </div>
    <?php if (!$isAdmin) { ?>
        <div class="nav-bottom-mobile ">
            <a href="/myPlants"><i class="fas fa-seedling"></i>My Plants</a>
            <a href="/addPlant"><i class="fas fa-plus-circle"></i>Add Plant</a>
            <a href="/discover"><i class="fas fa-university"></i>Discover</a>
        </div>
    <?php } ?>
</header>
<nav>
    <p class="my-plants-logo">gplant</p>
    <?php if ($isSession && !$isAdmin) { ?>
        <a href="/addPlant" class="add-plant">
            <i class="fas fa-plus-circle"></i>
            <p class="desc">Add New Plant</p>
        </a>
        <a href="/updateProfile" class="settings">
            <i class="fas fa-cog"></i>
            <p class="desc">Settings</p>
        </a>
    <?php } ?>
</nav>