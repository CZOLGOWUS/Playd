<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/registrationStyle.css">
    <script type="text/javascript" src="./public/js/registrationValidation.js" defer></script>
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

    <div class="registration-container">
        <?php
        if (isset($messages)) {
            foreach ($messages as $msg) {
                echo $msg;
            }
        }
        ?>
        <h1>Registration</h1>
        <form action="registerComplete" method="post">
            <div class="input-container">
                <label for="username">email
                    <input type="text" name="username" placeholder="your username">
                </label>
                <label for="email">email
                    <input type="email" name="email" placeholder="enter your email">
                </label>
                <label for="password">password
                    <input type="password" name="password" placeholder="enter strong password">
                </label>
                <label for="passwordConfirm">repeat password
                    <input type="password" name="passwordConfirm" placeholder="confirm password">
                </label>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>

</main>
</body>

</html>