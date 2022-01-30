<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/preferences-survey.css">
    <title>Welcome</title>
</head>

<body>

<div id="base-container">
    <nav class="nav-bar main-gradient">
        <div class="dropdown">
            <button class="hamburger-menu">
                <i class="fas fa-bars fa-lg">
                </i>
            </button>
            <ul>
                <a href="#">
                    <li>Profile</li>
                </a>
                <a href="#">
                    <li>Explore</li>
                </a>
                <a href="#">
                    <li>Browse</li>
                </a>
            </ul>
        </div>
        <input class="mobile-search-bar" type="text"></input>

        <div class="left-side">
            <a href="login" class="nav-button">Explore</a>
            <a href="dashboard" class="nav-button">Browse</a>
            <a href="dashboard" class="nav-button">Contact</a>
        </div>
        <div class="right-side">
            <input class="search-bar" type="text"></input>

            <a href="#" class="nav-button">
                <i class="fas fa-search fa-lg"></i>
            </a>

            <a href="login" class="nav-button">
                <i class="fas fa-user-alt fa-lg"></i>
            </a>
        </div>
    </nav>

    <main class="base-container">
        <img src="public/img/logo.png" class="logo-container" alt="">
        <div class="instruction-container">

        </div>
        <form action="profile"  method="get"  >
            <div class="ratings-container">
                <?php
                for ($i = 0; $i <= 11; $i++):
                    $nextAttribute = Game::getAllAttributes()[array_rand(Game::getAllAttributes())];
                    ?>
                    <div class="rating-container">
                        <div class="attribute">
                            <p><?php echo $nextAttribute; ?></p>
                        </div>
                        <div class="grades-container">
                            <?php for ($j = 0; $j <= 10; $j++):?>
                            <input label="<?php echo $j ?>" type="radio" name="<?php echo $i ?>" value="<?php echo $j ?>">
                            <?php endfor; ?>
                        </div>
                    </div>

                <?php endfor; ?>
            </div>

            <div class="footer">
                <button><i class="fas fa-caret-down fa-3x"></i></button>
                <button class="submit-button"><i class="fas fa-chevron-right fa-3x"></i></button>

            </div>
        </form>
</div>

</main>
</div>


<figure>
</body>

</html>