<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <title>Wiki</title>
</head>

<body class="wiki-body">
    <aside>
        <div class="brand">
            <img src="<?php echo URLROOT; ?>/assets/logo.png" alt="Logo">
            <div class="hidden">
                <h2>Wiki</h2>
            </div>
        </div>
        <nav>
            <a href="#"><i class="fa-solid fa-house"></i>
                <div class="hidden">
                    <h4>Home</h4>
                </div>
            </a>
            <a href="#"><i class="fa-solid fa-globe"></i>
                <div class="hidden">
                    <h4>Explore</h4>
                </div>
            </a>
            <a href="<?php echo URLROOT; ?>/users/loginPage"><i class="fa-solid fa-arrow-right-to-bracket"></i>
                <div class="hidden">
                    <h4>LogIn</h4>
                </div>
            </a>
        </nav>
    </aside>
    <article>
        <div class="header">
            <?php
            if ($_SESSION['auth']) {
                echo '<div class="header-left">
                        <div class="row">
                            <i class="fa-solid fa-circle-user"></i>
                            <h2>Welcome ' . $data['user']->fname . ' ' . $data['user']->lname . '</h2>
                        </div>
                        <p>👋 It\'s time to be creative!</p>
                    </div>';
            } else {
                echo '<div class="header-left">
                        <h2>Welcome Visitor!</h2>
                        <p>👋 It\'s time to be creative!</p>
                    </div>';
            }
            ?>
            <div class="header-right">
                <div class="search-bar">
                    <input type="text" name="searchInput" id="searchInput" placeholder="Search..." onkeydown="handleEnterKey(event)">
                    <i class="fa-solid fa-magnifying-glass" style="color: #b0b0b0;"></i>
                </div>
            </div>
        </div>
        <main>
            <div class="latest-wikis">
                <div class="title">Latest Wikis</div>
                <div class="cards">
                    <?php 
                        foreach ($data['wikis'] as $wiki) {
                            # code...
                        }
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="latest-cats">
                    <h2 class="title">Latest Categories</h2>
                    <?php
                    foreach ($data['categories'] as $category) {
                        echo '<div class="category">
                                <div >
                                    <h4>' . $category->title . '</h4>
                                    <p>' . $category->description . '</p>
                                </div>
                                <h4>' . $category->countWikis . ' Wikis</h4>
                            </div>';
                    }
                    ?>
                </div>
                <div class="latest-tags">
                    <h2 class="title">Trendy Tags</h2>
                    <div class="tags">
                        <?php
                        foreach ($data['tags'] as $tag) {
                            echo '<h4 class="capsule">#' . $tag->title . '</h4>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </article>
</body>

</html>