<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <title>Wiki Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body class="details-body">
    <section class="bg-light details-container rounded-3 d-flex flex-column p-3">
        <header class="wiki-header d-flex align-items-center gap-3">
            <a href="<?php echo URLROOT; ?>/users/dashboard" class="details-back"><i class="fa-solid fa-arrow-left"></i></a>
            <div class="d-flex align-items-center justify-content-between flex-wrap w-100">
                <h1><?php echo $data['wiki']->title ?></h1>
                <span style="color: #b0b0b0;">By <?php echo $data['wiki']->fname ?> <?php echo $data['wiki']->lname ?></span>
            </div>
        </header>
        <section class=" mt-3">
            <div class="details-content">
                <h4 style="color: var(--dark-blue);"><?php echo $data['category']->title ?></h4>
                <p class=""><?php echo $data['wiki']->content ?></p>
            </div>
            <div class="wiki-footer d-flex align-items-center justify-content-between flex-wrap">
                <div class="wiki-tags d-flex align-items-center gap-2">
                    <?php
                    foreach ($data['tags'] as $tag) {
                        echo '<span>#' . $tag->title . '</span>';
                    }
                    ?>
                </div>
                <p><?php echo $data['wiki']->created_at ?></p>
            </div>
        </section>
    </section>
</body>

</html>