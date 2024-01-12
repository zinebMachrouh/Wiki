<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT; ?>/public/js/script.js"></script>
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
            <a href="<?php echo URLROOT; ?>/categories/index"><i class="bi bi-bookmarks-fill"></i>
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
                <button type="button" onclick="opencatPopup()"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
        <main class="main-categories">
            <h2>All Categories</h2>
            <div class="allCategories">
                <?php
                foreach ($data['categories'] as $category) {
                    echo '<div class="adCategory">
                            <div class="adCategory-header">
                                <h4>' . $category->title . '</h4>
                                <div class="dropdown" style="float:right;">
                                            <button class="dropbtn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                            <div class="dropdown-content">
                                                <span>
                                                <a href="#" onclick="openmodCat(' . $category->id . ', \'' . $category->title . '\', \'' . $category->description . '\')"><i class="fa-solid fa-pencil" style="color: #42999B;"></i></a>                                                
                                                <a href="' . URLROOT . '/categories/deleteOne/' . $category->id . '"><i class="fa-solid fa-trash-can" style="color: #42999B;"></i></a>
                                                </span>
                                            </div>
                                </div>
                            </div>
                            <div class="adCategory-content">
                                <p>' . $category->description . '</p>
                                <span>Total Wikis : ' . $category->Total_Wikis . '</span>
                                <span>Archived Wikis : ' . $category->Archived_Count . '</span>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </main>
    </article>
    <div id="catPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Add Category</h2>
                <span class="close" onclick="closecatPopup()">&times;</span>
            </div>
            <div class="popup-body">
                <form action="<?php echo URLROOT; ?>/categories/addOne" method="post">
                    <label for="title" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Title:</label><br>
                    <input type="text" id="title" name="title" required placeholder="Enter Category Name" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>

                    <label for="description" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Description:</label><br>
                    <textarea id="description" name="description" required placeholder="Tell us about your category <3" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px; resize:none;"></textarea> <br>

                    <div class="popup-footer">
                        <button type="submit" class="btn btn-primary" name="setTeam">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modCatPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h2>Modify Category</h2>
                <span class="close" onclick="closemodCat()">&times;</span>
            </div>
            <div class="popup-body">
                <form action="<?php echo URLROOT; ?>/categories/modifyOne" method="post">
                    <label for="id" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Id:</label><br>
                    <input type="text" id="id" name="id" required placeholder="Category Id" readonly style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>

                    <label for="modTitle" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Title:</label><br>
                    <input type="text" id="modTitle" name="modTitle" required placeholder="Enter Category Name" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>

                    <label for="modDescription" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Description:</label><br>
                    <textarea id="modDescription" name="modDescription" required placeholder="Tell us about your category <3" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px; resize:none;"></textarea> <br>

                    <div class="popup-footer">
                        <button type="submit" class="btn btn-primary" name="setTeam">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>