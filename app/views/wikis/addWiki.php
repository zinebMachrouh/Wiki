<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Wiki</title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
</head>

<body class="login-body">
    <a href="<?php echo URLROOT; ?>/users/dashboard" class="back">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="create-form">
        <h2><img src="<?php echo URLROOT; ?>/assets/logoDark.png" alt=brand />Wiki</h2>

        <form action="<?php echo URLROOT; ?>/wikis/insertData" method="post">
            <label for="title">
                <h4>Title</h4>
                <input type="text" name="title" id="title" required placeholder="Enter Title">
            </label>
            <label for="content">
                <h4>Content</h4>
                <textarea type="text" name="content" id="content" cols="82" rows="5" required placeholder="Write a creative content <3" style="resize: none;"></textarea>
            </label>
            <label for="category">
                <h4>category</h4>
                <select name="category" id="category">
                    <option value="" hidden>Pick a Category</option>
                    <?php
                    foreach ($data['categories'] as $cat) {
                        echo '<option value="' . $cat->id . '">' . $cat->title . '</option>';
                    }
                    ?>
                </select>
            </label>
            <label for="tags">
                <h4>Tags</h4>
                <div class="addTags">
                    <?php
                    foreach ($data['tags'] as $tag) {
                        echo '<label class="tag" for="' . $tag->id . '"><input type="checkbox" name="tag[]" id="' . $tag->id . '" value="'. $tag->id.'">' . $tag->title . '</label>';
                    }
                    ?>
                </div>
            </label>
            <div class="btns">
                <button type="reset">Cancel</button>
                <button type="submit" name="sendF">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>