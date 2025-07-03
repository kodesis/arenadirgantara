<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= $title ?> - Arena Dirgantara</title>

    <!-- theme meta -->
    <meta name="theme-name" content="mono" />

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
    <link href="<?= base_url() ?>assets/dashboard/plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/dashboard/plugins/simplebar/simplebar.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="<?= base_url() ?>assets/dashboard/plugins/nprogress/nprogress.css" rel="stylesheet" />

    <link href="<?= base_url() ?>assets/dashboard/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/dashboard/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/dashboard/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/dashboard/plugins/toaster/toastr.min.css" rel="stylesheet" />

    <!-- MONO CSS -->
    <link id="main-css-href" rel="stylesheet" href="<?= base_url() ?>assets/dashboard/css/style.css" />

    <!-- FAVICON -->
    <link href="<?= base_url() ?>assets/landing-page/img/logo/preloader.png" rel="shortcut icon" />

    <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <script src="<?= base_url() ?>assets/dashboard/plugins/nprogress/nprogress.js"></script>
    <script src="<?= base_url() ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
        .swal2-container {
            z-index: 99999 !important;
        }
    </style>
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
    <script>
        NProgress.configure({
            showSpinner: false
        });
        NProgress.start();
    </script>

    <!-- <div id="toaster"></div> -->

    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">

        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->

        <?php $this->load->view('layouts/dashboard/_sidebar') ?>
        <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
        <div class="page-wrapper">

            <!-- Header -->
            <?php $this->load->view('layouts/dashboard/_navbar') ?>

            <!-- ====================================
        ——— CONTENT WRAPPER
        ===================================== -->
            <div class="content-wrapper">

                <?php $this->load->view($pages) ?>

            </div>

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="copyright bg-white">
                    <p>
                        &copy; <span id="copy-year"></span> Copyright Arena Dirgantara. Template Mono Dashboard Bootstrap by <a class="text-primary" href="http://www.iamabdus.com/" target="_blank">Abdus</a>.
                    </p>
                </div>
                <script>
                    var d = new Date();
                    var year = d.getFullYear();
                    document.getElementById("copy-year").innerHTML = year;
                </script>
            </footer>

        </div>
    </div>

    <!-- Card Offcanvas -->
    <div class="card card-offcanvas" id="contact-off">
        <div class="card-header">
            <h2>Contacts</h2>
            <a href="#" class="btn btn-primary btn-pill px-4">Add New</a>
        </div>
        <div class="card-body">

            <div class="mb-4">
                <input type="text" class="form-control form-control-lg form-control-secondary rounded-0" placeholder="Search contacts...">
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-01.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Selena Wagner</span>
                        <span class="discribe">Designer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-02.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Walter Reuter</span>
                        <span>Developer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-03.jpg" alt="User Image">
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Larissa Gebhardt</span>
                        <span>Cyber Punk</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-04.jpg" alt="User Image">
                    </a>

                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Albrecht Straub</span>
                        <span>Photographer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-05.jpg" alt="User Image">
                        <span class="active bg-danger"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Leopold Ebert</span>
                        <span>Fashion Designer</span>
                    </a>
                </div>
            </div>

            <div class="media media-sm">
                <div class="media-sm-wrapper">
                    <a href="user-profile.html">
                        <img src="<?= base_url() ?>assets/dashboard/images/user/user-sm-06.jpg" alt="User Image">
                        <span class="active bg-primary"></span>
                    </a>
                </div>
                <div class="media-body">
                    <a href="user-profile.html">
                        <span class="title">Selena Wagner</span>
                        <span>Photographer</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="<?= base_url() ?>assets/dashboard/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/plugins/simplebar/simplebar.min.js"></script>
    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/plugins/apexcharts/apexcharts.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/plugins/toaster/toastr.min.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/js/chart.js"></script>
    <script src="<?= base_url() ?>assets/dashboard/js/custom.js"></script>

    <script src="<?= base_url() ?>assets/vendor/select2/js/select2.min.js"></script>
    <script src="<?= base_url() ?>assets/script.js"></script>

    <script>
        $(document).on('click', '#btnApprove', function() {
            $('#statusField').val('confirmed');
            $('#formViewBooking').submit();
        });

        $(document).on('click', '#btnReject', function() {
            $('#editData').modal('hide'); // ← Tutup modal Bootstrap dulu

            setTimeout(() => {
                Swal.fire({
                    title: 'Reject Booking',
                    input: 'textarea',
                    inputLabel: 'Reason for rejection',
                    inputPlaceholder: 'Type the reason...',
                    inputAttributes: {
                        'aria-label': 'Catatan penolakan'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    inputValidator: (value) => {
                        if (!value.trim()) {
                            return 'Reason is required!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#statusField').val('rejected');
                        $('#alasanField').val(result.value.trim());
                        $('#formViewBooking').submit();
                    } else {
                        // Kalau cancel, buka kembali modal booking
                        $('#editData').modal('show');
                    }
                });
            }, 300); // kasih delay sedikit agar modal benar-benar tertutup dulu
        });
    </script>

</body>

</html>