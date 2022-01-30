<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/addNewAttribute.js" defer></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/profileStyle.css">
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
            <a href="profile"><li>Profile</li></a>
            <a href="explore"><li>Explore</li></a>
        </ul>
    </div>
    <input class="mobile-search-bar" type="text">
    
    <div class="left-side">
        <a href="explore" class="nav-button">Explore</a>
        <a href="explore" class="nav-button">Contact</a>
    </div>
    <div class="right-side">
        <input class="search-bar" type="text">
        
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
    
        <div class="profile-options profile-column">
            <p><?php echo $user->getUsername(); ?></p>
            <div class="avatar">

                <div class="image">
                
                </div>
                <a href="#"><p>change avatar</p></a>
            </div>
            <?php for ($i=0;$i<3;$i++): ?>
            <div class="settings">
                <h3>setting #</h3>
                <label class="switch">
                    <input type="checkbox" name="setting-1">
                    <span class="slider"></span>
                </label>
            </div>
            <?php endfor; ?>
            <a href="addGame">
                <button type="button">add game</button>
            </a>
        </div>
        
        <div class="choice-score profile-column">
            <h1>Score based on choice</h1>

            <form action="profile" method="post">
                <div class="attribute-container">
                    <?php
                    $userAttributes = $user->getAttributes();
                    foreach($userAttributes as $attribute => $score ) :  ?>
                        <div class="game-attribute">
                            <div class="attribute-name"><?php echo $attribute; ?></div>
                            <div class="attribute-score"><?php echo $score; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="button" class="add-attribute-button"> add new attributes </button>
                <div class="submit-changes-button"></div>
            </form>
        </div>
        
        <div class="games-played-score profile-column">
            <h1>Score based on games played</h1>
            <p>not implemented</p>
        </div>
    
    </div>
</main>
</body>

</html>