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
                foreach ($data['tags'] as $category) {
                    echo '<div class="adCategory">
                            <div class="adCategory-header">
                                <h4>#' . $category->title . '</h4>
                                <div class="dropdown" style="float:right;">
                                            <button class="dropbtn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                            <div class="dropdown-content">
                                                <span>
                                                <a href="#" onclick="openmodCat(' . $category->id . ', \'' . $category->title . '\')"><i class="fa-solid fa-pencil" style="color: #42999B;"></i></a>                                                
                                                <a href="' . URLROOT . '/tags/deleteOne/' . $category->id . '"><i class="fa-solid fa-trash-can" style="color: #42999B;"></i></a>
                                                </span>
                                            </div>
                                </div>
                            </div>
                            <div class="adCategory-content">
                                <span>Total Wikis : ' . $category->Total_Wikis . '</span>
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
                <form action="<?php echo URLROOT; ?>/tags/addOne" method="post">
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
                <form action="<?php echo URLROOT; ?>/modifyOne/modifyOne" method="post">
                    <label for="id" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Id:</label><br>
                    <input type="text" id="id" name="id" required placeholder="Category Id" readonly style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>

                    <label for="modTitle" style="color: #006d77ff; font-size: 16px; font-weight: 600;">Category Title:</label><br>
                    <input type="text" id="modTitle" name="modTitle" required placeholder="Enter Category Name" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>

                    <div class="popup-footer">
                        <button type="submit" class="btn btn-primary" name="setTeam">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="overlay" id="overlay">
        <div class="modal" id="searchPopup">
            <h2 id="popupTitle">Search results</h2>
            <div id="searchData"></div>
            <button onclick="closeSearchModal()">Close</button>
        </div>
    </div>

    <script>
        function handleEnterKey(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                searchAndDisplay();
            }
        }

        function displayPopupWithData(dataArray) {
            var container = document.getElementById('searchData');
            container.innerHTML = '';
            dataArray.forEach(function(data) {
                var url = '<?php echo URLROOT; ?>/wikis/wikiDetails/' + data.id;
                var row = document.createElement('div');
                row.classList = 'searchCard'

                row.innerHTML = `
                    <div class="card-header">
                        <h4>${data.title}</h4>
                        <a href="${url}"><i class="fa-solid fa-arrow-up-right-from-square" style="color: #42999B;"></i></a>
                    </div>
                    <div class="card-content">
                        <span>${data.category !== null ? data.category : 'Category Not Assigned'}</span>
                        <p>${data.content}</p>
                    </div>
                    <div class="card-footer">
                        <span>By ${data.fname} ${data.lname}</span>
                    </div>
                `;

                container.appendChild(row);
            });
            document.getElementById('overlay').style.display = 'flex';

            document.getElementById('searchPopup').style.display = 'flex';

        }

        function closeSearchModal() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('searchPopup').style.display = 'none';
            document.getElementById('searchInput').value = '';
        }

        function searchAndDisplay() {
            var searchTerm = document.getElementById('searchInput').value;

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    displayPopupWithData(data);
                }
            };
            xhr.open('GET', '<?php echo URLROOT; ?>/wikis/searchData/' + searchTerm, true);
            xhr.send();
        }
    </script>
</body>

</html>