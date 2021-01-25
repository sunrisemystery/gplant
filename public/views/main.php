<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="icon" type="image/png" sizes="16x16" href="public/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eadaeebdec.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/main-page.css">
    <script type="text/javascript" src="./public/js/hamburgerMenu.js" defer></script>
    <script type="text/javascript" src="./public/js/popUp.js" defer></script>

</head>

<body class="main-container">
    <header>
        <p class="logo-main">gplant</p>
        <nav>
            <div class="nav-mobile">
                <div class="hamburger-menu">
                    <a class="active"></a>
                    <div id="options">
                        <?php if ($isSession) { ?>
                            <?php if ($isAdmin) { ?>
                                <a href="/adminView">Admin Panel</a>
                            <?php } else { ?>
                                <a href="/myPlants">My Plants</a>
                            <?php } ?>
                        <?php } else { ?>
                            <a id="contact-mobile">Info</a>
                        <?php } ?>
                        <a href="/discover">Discover</a>
                    </div>
                    <a class="icon" onclick="openMenu()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <?php if ($isSession) { ?>
                    <a href="/login" class="sign">SIGN OUT</a>
                <?php } else { ?>
                    <a href="/login" class="sign">SIGN IN</a>
                <?php } ?>
            </div>
            <div class="nav-desktop">
                <ul>
                    <li><a href="/">home</a></li>
                    <li><a href="/discover">discover</a></li>
                    <?php if ($isSession) { ?>
                        <?php if ($isAdmin) { ?>
                            <li><a href="/adminView">Admin Panel</a></li>
                        <?php } else { ?>
                            <li><a href="/myPlants">My Plants</a></li>
                        <?php } ?>
                        <li><a href="/login">sign out</a></li>
                    <?php } else { ?>
                        <li><a id="contact">info</a></li>
                        <li><a href="/login">sign in</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <? include("components/pop-up-window.php") ?>
        <div class="img-main-container">
            <p class="logo-mobile">gplant</p>
            <div class="main-img"></div>
            <div class="img-text">
                <p>Taking care of plants is our priority. Join us today to give your plants better life.</p>
            </div>
        </div>
        <section>
            <p><strong>Lorem ipsum dolor</strong> sit amet consectetur adipisicing elit. Rerum eos adipisci sunt non,
                quidem beatae. Et ex incidunt ut. Exercitationem, odit sapiente. Illum consequatur quibusdam veritatis
                at a exercitationem quo voluptates doloremque nisi aliquam fugiat minus doloribus error, cum id? Ab
                expedita perspiciatis, quisquam accusamus incidunt sit repellendus saepe maxime possimus nesciunt neque
                nostrum voluptatum. Non fugit ducimus similique voluptatem nihil necessitatibus cumque harum quibusdam,
                numquam error adipisci explicabo. Doloremque reprehenderit optio itaque dolorem sit! Culpa consequuntur
                sapiente id enim dignissimos vitae necessitatibus harum esse inventore saepe voluptatum sed sunt
                voluptate eos, ipsum, nobis iste. Delectus dolores, ullam ab dolor rem incidunt ipsam vitae ipsa error a
                facere consequatur amet distinctio voluptates magni doloribus quos. Harum dolores quos, esse nesciunt
                dignissimos nisi saepe natus accusamus commodi minima corporis dicta rem unde ipsum impedit odio. Sit
                numquam veniam molestiae eos facilis laudantium illo repellat nisi ex ipsa omnis placeat laboriosam
                dolor, nulla esse iure. Perspiciatis autem unde a sapiente quis iste nihil quod commodi repudiandae
                error atque magnam rerum veniam reiciendis illo ipsa, esse aliquid, ducimus aut. Deserunt iusto cum
                necessitatibus nobis in dignissimos quisquam porro nostrum, temporibus laboriosam corrupti sunt
                accusamus odio ullam odit ratione veniam, quia nulla? Odio, possimus.</p>
        </section>
    </main>
</body>

</html>