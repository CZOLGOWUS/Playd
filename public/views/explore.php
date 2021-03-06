<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/fetchGames.js" defer ></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/exploreStyle.css">
    <title>Welcome</title>
</head>

<body>
<nav class="nav-bar main-gradient">
    <div class="dropdown">
        <button class="hamburger-menu">
            <i class="fas fa-bars fa-lg">
            </i>
        </button>
        <ul>
            <a href="profile">
                <li>Profile</li>
            </a>
            <a href="explore">
                <li>Explore</li>
            </a>
            <a href="#">
                <li>Browse</li>
            </a>
        </ul>
    </div>
    <input class="mobile-search-bar" type="text"></input>

    <div class="left-side">
        <a href="explore" class="nav-button">Explore</a>
        <a href="contact" class="nav-button">Contact</a>
    </div>
    <div class="right-side">
        <input class="search-bar" type="text" placeholder="search for games"></input>

        <a href="#" class="nav-button">
            <i class="fas fa-search fa-lg"></i>
        </a>

        <a href="login" class="nav-button">
            <i class="fas fa-user-alt fa-lg"></i>
        </a>
    </div>
</nav>

<main class="content-container">
    <div class="content-wrapper">
    <?php
    if(!isset($games))
        return;
    $gamesCount = count($games);
    for ($i=0; $i < $gamesCount  ;$i++) : ?>
    
    <?php
        $currentGame = $games[$i];
        $gameAttributes = $games[$i]->getAttributes();
        ?>
        <div class="small-game-container">
            <a
                href="gamePage?<?php echo 'title=' . $currentGame->getTitle() .'&id_game='. $currentGame->getId() ?>"
            class="photo">
                <?php if ($games[$i]->getImage(0) !== ""): ?>
                    <img src="public/uploads/<?php echo $games[$i]->getImage(0) ?>" alt="<?php echo $games[$i]->getImage(0) ?>">
                <?php else : ?>
                    <p><?php echo $games[$i]->getTitle(); ?></p>
                <?php endif; ?>
            </a>
            <div class="score-info">

                <?php
                    $count = 0;
                    foreach ($gameAttributes as $name => $score):
                ?>
                <div class="score">
                    <p class="attribute-name"><?php echo $name; ?> </p>
                    <p class="attribute-score" ><?php echo round($score,1) == 0 ? null : round($score,1); ?> </p>
                </div>
                <?php
                    $count++;
                    if ($count >= 3)
                    {
                        $count = 0;
                        break;
                    }
                    endforeach;
                ?>
            </div>
        </div>
    <?php endfor; ?>
    </div>
    <div class="more-icon">
        <button><i class="fas fa-caret-down fa-3x"></i></button>
    </div>
</main>
</body>

<template id="game-template">
    <div class="small-game-container">
        
        <a href="" class="photo"><img src="" alt=""></a>
        <div class="score-info">
            <div class="score">
                <p class="attribute-name">attribute</p>
                <p class="attribute-score">score</p>
            </div>
        </div>
        
    </div>
</template>

</html>