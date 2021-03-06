<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/49313450ad.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
    <link rel="stylesheet" type="text/css" href="public/css/addGameStyles.css">
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
                <a href="#"><li>Browse</li></a>
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

            <h1>Upload</h1>
            <form action="addGame" method="post" enctype="multipart/form-data">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $msg) {
                        echo $msg;
                    }
                }
                ?>
                <input type="text" name="title" placeholder="title">
                <textarea name="description" rows="5" placeholder="description"></textarea>
                <input type="file" name="file" >
                <button type="submit">upload</button>
            </form>

        </div>
    </main>
</body>

</html>