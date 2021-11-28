<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/login-styles.css">
    <title>Welcome</title>
</head>

<body>
<div id="base-container">
    <nav class="nav-bar main-gradient">
        <div>
            <a href="login" class="nav-button">Explore</a>
            <a href="dashboard" class="nav-button">Browse</a>
            <a href="dashboard" class="nav-button">Contact</a>
        </div>
        <div>
            <input id="search-bar" type="text"></input>

            <a href="#" class="nav-button">
                <i class="fas fa-search fa-lg" style="color: white;"></i>
            </a>

            <a href="login" class="nav-button">
                <i class="fas fa-user-alt fa-lg"></i>
            </a>
        </div>
    </nav>

    <main class="content-container">
        <div class="content">
            <img src="public/img/logo.svg" alt="logo" id="logo">
            <form id="login-window" method="post">
                <div class="left">
                    <?php
                    if (isset($messages)) {
                        foreach ($messages as $msg) {
                            echo $msg;
                        }
                    }
                    ?>
                    <div class="input-box">
                        <input name="email" placeholder="login" type="email"></input>
                    </div>
                    <div class="input-box">
                        <input name="password" placeholder="password" type="password"></input>
                    </div>
                    <div class="fotter">
                        <h3><a href="#">Register</a> | <a href="#">Forgot password</a></h3>
                        <a href="#"><h4>Login with Google</h4></a>
                    </div>
                </div>
                <div class="right">
                    <button class="button-75" role="button" type="submit"><span class="text">Login</span></button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>

</html>