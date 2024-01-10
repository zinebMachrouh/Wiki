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
        <h2>Data<img src="<?php echo URLROOT; ?>/assets/logo.png" alt=brand />are</h2>

        <form action="<?php echo URLROOT; ?>/projects/createProject" method="post">
            <label for="name">
                <h4>Project Name</h4>
                <input type="text" name="name" id="name" required placeholder="Enter Project Name">
            </label>
            <label for="date_start">
                <h4>Start Date</h4>
                <input type="date" name="date_start" id="date_start" required>
            </label>
            <label for="date_end">
                <h4>End Date</h4>
                <input type="date" name="date_end" id="date_end" required>
            </label>
            <label for="status">
                <h4>Status</h4>
                <select name="status" id="status">
                    <option value="" hidden>Pick a status</option>
                    <option value="0">Active</option>
                    <option value="1">Done</option>
                </select>
            </label>
            <label for="description">
                <h4>Description</h4>
                <input type="text" name="description" id="description" placeholder="lorem ipsum doleres">
            </label>
            <div class="btns">
                <button type="reset">Cancel</button>
                <button type="submit" name="sendF">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>