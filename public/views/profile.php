<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
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
    <input class="mobile-search-bar" type="text"></input>
    
    <div class="left-side">
        <a href="explore" class="nav-button">Explore</a>
        <a href="explore" class="nav-button">Contact</a>
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
    <div class="content-wrapper">
    
        <div class="profile-options profile-column">
            <div class="avatar">
                <div class="image">
                
                </div>
                <p>change avatar</p>
            </div>
            <?php for ($i=0;$i<3;$i++): ?>
            <div class="settings">
                <h3>setting 1</h3>
                <label class="switch">
                    <input type="checkbox" name="setting-1">
                    <span class="slider"></span>
                </label>
            </div>
            <?php endfor; ?>
        </div>
        <div class="choice-score profile-column">
        
        </div>
        <div class="games-played-score profile-column">
        
        </div>
    
    </div>
</main>
</body>

</html>