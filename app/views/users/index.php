<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>

    <title>LogIn</title>
</head>

<body class="login-body">
    <a href="<?php echo URLROOT; ?>/users/index" class="back">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <div class="login-page">
        <div class="left">
            <img src="<?php echo URLROOT; ?>/assets/logo.png" alt="logo">
            <h2>Welcome <br> Back!</h2>
        </div>
        <div class="right">
            <h4 class="title">LogIn</h4>
            <p>Welcome back! Please login to your account.</p>
            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <label for="email">
                    <h4>Email</h4>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
                </label>
                <label for="password">
                    <h4>Password</h4>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                </label>
                <div class="btns">
                    <button type="reset">Cancel</button>
                    <button type="submit" name="sendF">Submit</button>
                </div>
            </form>
            <p class="sign">Don't Have an account? <a href="<?php echo URLROOT; ?>/users/signupPage">SignUp</a></p>

        </div>
    </div>
    <script>
        const emailRegex = /^[a-zA-Z0-9.-_]+@[a-zA-Z]+\.[a-z]{2,}$/;
        const passwordRegex = /^[A-Za-z\d]{8,}$/;

        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (!emailRegex.test(emailInput.value)) {
                alert('Invalid email format');
                event.preventDefault();
            }

            if (!passwordRegex.test(passwordInput.value)) {
                alert('Password must be at least 8 characters');
                event.preventDefault();
            }
        });
    </script>
</body>

</html>