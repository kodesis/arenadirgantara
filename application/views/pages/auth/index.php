<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?> - Arena Dirgantara App</title>
    <meta name="description" content="Apexa - Business Consulting HTML Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/landing-page/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->
    <!-- CSS here -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/animate.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/flaticon.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/default.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/main.css">
    <script src="<?= base_url() ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

</head>

<body>
    <!--Preloader-->
    <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="<?= base_url() ?>assets/landing-page/img/logo/arena-dirgantara-logo.png" alt="Preloader"></div>
            </div>
        </div>
    </div>
    <!--Preloader-end -->
    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->
    <!-- main-area -->
    <main class="fix">
        <!-- about-area -->
        <section class="login__area-one">
            <div class="container">
                <div class="box-form-login">
                    <?php $this->load->view($pages) ?>
                </div>
            </div>
        </section>
        <!-- about-area-end -->
    </main>
    <!-- main-area-end -->
    <!-- JS here -->
    <script src="<?= base_url() ?>assets/landing-page/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/main.js"></script>
</body>

</html>