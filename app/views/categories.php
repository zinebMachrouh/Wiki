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
    </article>
</body>

</html>