<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/gamePageStyles.css">
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
                <a href="#"><li>Profile</li></a>
                <a href="#"><li>Explore</li></a>
            </ul>
        </div>
        <input class="mobile-search-bar" type="text"></input>

        <div class="left-side">
            <a href="explore" class="nav-button">Explore</a>
            <a href="contact" class="nav-button">Contact</a>
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

    <main class="content-container">
        
            <div class="main-game-info">
                <div class="game-photos">
                    <div class="photo-frame">
                        <div class="photo-selected">
                            <img src="public/uploads/<?php echo $game->getImage(0); ?>" >
                        </div>
                    </div>
                    <div class="photo-gallery">
                        <?php
                            $imageCount = count($game->getAllImages());
                            for ($i=1;$i < $imageCount && $i < 5;$i++): ?>
                            <div class="photo-in-gallery">
                                <img src="public/uploads/<?php echo $game->getImage($i); ?>">
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="socials-scores">
                        <div class="social-icons">
                            <div class="social-icon">
                            
                            </div>
                            <div class="social-icon">

                            </div>
                        </div>
                        <div class="score-icons">
                            <div class="score-icon">
                            
                            </div>
                            <div class="review-score">
                                <p>5.6</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="game-description">
                
                </div>
                
            </div>
            
            <div class="more-game-info">
                <div class="reviews-wrapper">
                
                </div>
                <div class="important-info-wrapper">
                
                </div>
            </div>
            
            
<!--            <h1>Game Page</h1>-->
<!--            --><?php //if(isset($game)) : ?>
<!--                <img src="/public/uploads/--><?php //$game->getImage() ?><!--">-->
<!--                <h2>--><?//= $game->getTitle() ?><!--</h2>-->
<!--                <h3>--><?//= $game->getDescription() ?><!--</h3>-->
<!--            --><?php //else : ?>
<!--                <p>could not load game page<p>-->
<!--            --><?php //endif; ?>
    
    </main>
</body>

</html>