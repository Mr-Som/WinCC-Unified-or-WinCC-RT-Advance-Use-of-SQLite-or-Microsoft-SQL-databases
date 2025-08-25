<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/url.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url('/assets/css/login.css'); ?>" />
    <!-- Font -->
    <link
        href="<?= vendor_url('/fonts/googleapis/css/css2.css?family=Inter:wght@300;400;500;600&display=swap'); ?>"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="<?= vendor_url('/materialdesign/v7.4.47/css/materialdesignicons.min.css'); ?>" />
    <title>LogIn page</title>
</head>

<body class="d-flex-column">
    <section class="container d-flex-column">
        <img
            src="<?= base_url('/assets/image/logo_dark.svg'); ?>"
            alt="logo"
            height="200"
            width="200" />
        <form>
            <div class="inp-container">
                <span class="mdi mdi-account-outline"></span>
                <input class="inp" type="text" name="name" placeholder="Username" />
            </div>
            <div class="inp-container">
                <span class="mdi mdi-lock-outline"></span>
                <input
                    class="inp"
                    type="password"
                    name="password"
                    placeholder="Password" />
            </div>
            <button class="btn">LogIn</button>
        </form>
    </section>
</body>

</html>