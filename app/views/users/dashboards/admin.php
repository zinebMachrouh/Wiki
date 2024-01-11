<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            <a href="<?php echo URLROOT; ?>/users/dashboard"><i class="bi bi-grid-1x2-fill"></i>
                <div class="hidden">
                    <h4>Home</h4>
                </div>
            </a>
            <a href="<?php echo URLROOT; ?>/users/profile"><i class="bi bi-bookmarks-fill"></i>
                <div class="hidden">
                    <h4>Profile</h4>
                </div>
            </a>
            <a href="<?php echo URLROOT; ?>/wikis/addWiki"><i class="fa-solid fa-hashtag"></i>
                <div class="hidden">
                    <h4>Add Wiki</h4>
                </div>
            </a>
            <a href="<?php echo URLROOT; ?>/users/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i>
                <div class="hidden">
                    <h4>LogOut</h4>
                </div>
            </a>
        </nav>
    </aside>
    <article>
        <div class="header">
            <?php
            echo '<div class="header-left">
                        <h2>Welcome ' . $data['user']->fname . ' ' . $data['user']->lname . '</h2>
                        <p>👋 It\'s time to be creative!</p>
                    </div>';
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
                <h2>Latest Wikis</h2>
                <div class="cards">
                    <?php
                    foreach ($data['wikis'] as $wiki) {
                        $date = new DateTime($wiki->created_at);
                        echo '<div class="card">
                                <div class="card-side" style="background: url(' . URLROOT . '/assets/mini-bg.png)">
                                </div>
                                <div class="card-body">
                                    <div class="card-header">
                                        <h4>' . $wiki->title . '</h4>
                                        <a href="' . URLROOT . '/wikis/wikiDetails/' . $wiki->id . '"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                    </div>
                                    <div class="card-content">
                                        <span>' . $wiki->category . '</span>
                                        <p>' . $wiki->content . '</p>
                                    </div>
                                    <div class="card-footer">
                                        <span>By ' . $wiki->fname . ' ' . $wiki->lname . '</span>
                                        <span>' . $date->format('d-m-Y') . '</span>
                                    </div>
                                </div>
                            </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="latest-cats">
                    <h2>Latest Categories</h2>
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
                    <h2>Trendy Tags</h2>
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