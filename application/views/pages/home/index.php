<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $title ?> - Arena Dirgantara</title>
    <meta name="description" content="<?= $title ?> - Arena Dirgantara">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/landing-page/img/favicon.png">
    <!-- Place favicon.ico in the root directory -->
    <!-- CSS here -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/animate.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/flaticon.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/odometer.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/swiper-bundle.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/aos.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/default.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/landing-page/css/main.css">

    <script src="<?= base_url() ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>
    <style>
        .fc-event-time {
            display: none !important;
        }

        .slot-button {
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            /* text-overflow: ellipsis; */
        }

        /* Hapus arrow otomatis di tombol slot */
        .btn::after {
            content: none !important;
        }
    </style>
</head>

<body>
    <!--Preloader-->
    <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="<?= base_url() ?>assets/landing-page/img/logo/preloader.png" alt="Preloader"></div>
            </div>
        </div>
    </div>
    <!--Preloader-end -->
    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->
    <!-- header-area -->
    <header class="tg-header__style-five">
        <div class="tg-header__top">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tg-header__top-info left-side list-wrap">
                            <li><i class="flaticon-phone-call"></i><a href="tel:0123456789">0819 9000 0360</a></li>
                            <li><i class="flaticon-pin"></i>Jl. D.I. Panjaitan, Jatinegara</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul class="tg-header__top-right list-wrap">
                            <li><i class="flaticon-envelope"></i><a href="mailto:info@arenadirgantara.com">info@arenadirgantara.com</a></li>
                            <li><i class="flaticon-time"></i>Everyday: 07:00 - 23:00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-header" class="tg-header__area">
            <div class="container custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="logo">
                                    <a href="<?= base_url() ?>"><img src="<?= base_url() ?>assets/landing-page/img/logo/logo.png" alt="Logo"></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                    <ul class="navigation">

                                        <li class="<?= ($this->uri->segment(1) == '') ? 'active' : '' ?>"><a href="<?= base_url() ?>">Home</a></li>
                                        <li class="<?= ($this->uri->segment(2) == 'gallery') ? 'active' : '' ?>"><a href=" <?= base_url('home/gallery') ?>">Gallery</a></li>
                                        <li class="<?= ($this->uri->segment(2) == 'booking' or $this->uri->segment(2) == 'checkout') ? 'active' : '' ?>"><a href=" <?= base_url('home/booking') ?>">Booking</a></li>
                                        <li class="<?= ($this->uri->segment(2) == 'contact') ? 'active' : '' ?>"><a href=" <?= base_url('home/contact') ?>">Contact</a></li>
                                    </ul>
                                </div>
                                <div class="tgmenu__action tgmenu__action-five d-none d-md-block">
                                    <ul class="list-wrap">
                                        <li class="header-btn"><a href="<?= base_url(($this->session->userdata('is_logged_in') == true) ? 'dashboard' : 'auth') ?>" class="btn"><?= ($this->session->userdata('is_logged_in') == true) ? 'Hello, ' . $this->session->userdata('name') : 'log in' ?></a></li>
                                    </ul>
                                </div>
                                <div class="mobile-nav-toggler mobile-nav-toggler-two">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                        <path d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z" fill="currentcolor" />
                                        <path d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z" fill="currentcolor" />
                                        <path d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z" fill="currentcolor" />
                                        <path d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z" fill="currentcolor" />
                                        <path d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z" fill="currentcolor" />
                                        <path d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z" fill="currentcolor" />
                                        <path d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z" fill="currentcolor" />
                                        <path d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z" fill="currentcolor" />
                                        <path d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z" fill="currentcolor" />
                                    </svg>
                                </div>
                            </nav>
                        </div>
                        <!-- Mobile Menu  -->
                        <div class="tgmobile__menu">
                            <nav class="tgmobile__menu-box">
                                <div class="close-btn"><i class="fas fa-times"></i></div>
                                <div class="nav-logo">
                                    <a href="index.html"><img src="<?= base_url() ?>assets/landing-page/img/logo/logo.png" alt="Logo"></a>
                                </div>
                                <div class="tgmobile__search">
                                    <form action="#">
                                        <input type="text" placeholder="Search here...">
                                        <button><i class="fas fa-search"></i></button>
                                    </form>
                                </div>
                                <div class="tgmobile__menu-outer">
                                    <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                                </div>
                                <div class="tgmobile__menu-bottom">
                                    <div class="contact-info">
                                        <ul class="list-wrap">
                                            <li><a href="mailto:info@arenadirgantara.com">info@arenadirgantara.com</a></li>
                                            <li><a href="tel:0123456789">0819 9000 0360</a></li>
                                        </ul>
                                    </div>
                                    <div class="social-links">
                                        <ul class="list-wrap">
                                            <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="javascript:void(0)"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div class="tgmobile__menu-backdrop"></div>
                        <!-- End Mobile Menu -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-area-end -->
    <!-- main-area -->
    <main class="fix">
        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_success') ?>"></div>
        <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('message_error') ?>"></div>
        <?php $this->load->view($pages) ?>
    </main>
    <!-- main-area-end -->
    <!-- footer-area -->
    <footer>
        <div class="footer__area-two footer__area-six">

            <div class="footer__bottom-two">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="copyright-text-two">
                                <p>Copyright © <a href="<?= base_url() ?>">Arena Dirgantara</a> | All Right Reserved</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="footer__social-two">
                                <ul class="list-wrap">
                                    <li><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Booking -->
    <div class="modal fade" id="modalBooking" tabindex="-1" aria-labelledby="modalBookingLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- posisi di tengah -->
            <div class="modal-content shadow-lg">
                <form action="<?= site_url('home/checkout') ?>" method="post">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="modalBookingLabel">Form Booking Lapangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"> -->
                        <input type="hidden" name="tanggal" id="tanggal_booking" readonly>
                        <div class="row ">
                            <!-- <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Nomor HP</label>
                                    <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Email (Opsional)</label>
                                    <input type="email" name="email" class="form-control" placeholder="Contoh: email@domain.com">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Booking</label>
                                    <input type="text" class="form-control" name="tanggal" id="tanggal_display" readonly>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Slot Jam</label>
                                    <div id="slot_jam_container" class="row g-2">
                                    </div>
                                    <input type="hidden" name="jam" id="selected_jam" readonly required>
                                </div>
                            </div>

                            <input type="hidden" class="form-control" name="total_jam" id="total_jam" readonly>
                            <!-- <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="floatingInputGroup1">Total jam</label>
                                    <div class="input-group">
                                        <span class="input-group-text">jam</span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn border-btn">Lanjut booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- footer-area-end -->
    <!-- JS here -->
    <script src="<?= base_url() ?>assets/landing-page/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/jquery.magnific-popup.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/jquery.odometer.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/jquery.appear.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/gsap.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/ScrollTrigger.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/SplitText.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/gsap-animation.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/jquery.parallaxScroll.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/swiper-bundle.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/ajax-form.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/wow.min.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/aos.js"></script>
    <script src="<?= base_url() ?>assets/landing-page/js/main.js"></script>
    <script src="<?= base_url() ?>assets/script.js"></script>
    <script>
        function rangeSlide(value) {
            document.getElementById('rangeValue').innerHTML = value;
        }
    </script>

    <script>
        const csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

        let selectedSlots = [];
        let data = [];

        // Set CSRF untuk semua AJAX
        $.ajaxSetup({
            data: {
                [csrfName]: csrfHash
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // const today = new Date().toISOString().split('T')[0];
            const today = "<?= date('Y-m-d') ?>";
            console.log(today);

            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                selectable: true,
                events: {
                    url: '<?= site_url('home/get_calendar_data') ?>',
                    method: 'GET',
                },
                dateClick: function(info) {
                    let selectedDate = info.dateStr;

                    if (selectedDate < today) {
                        Swal.fire({
                            title: "Error!",
                            text: 'Tanggal sudah lewat. Silakan pilih tanggal lain.',
                            icon: "error",
                        });
                        return;
                    }

                    $('#modalBooking').modal('show');
                    $('#tanggal_booking').val(selectedDate);
                    $('#tanggal_display').val(selectedDate);

                    loadSlotJam(selectedDate);
                },
                dayCellDidMount: function(info) {
                    const today = '<?= date('Y-m-d') ?>';
                    const cellDate = info.date.getFullYear() + '-' +
                        String(info.date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(info.date.getDate()).padStart(2, '0');

                    if (cellDate < today) {
                        info.el.style.backgroundColor = '#f0f0f0';
                        info.el.style.color = '#999';
                        info.el.style.pointerEvents = 'none';
                        info.el.style.opacity = '0.6';
                    }
                }
            });

            calendar.render();
        });

        function loadSlotJam(tanggal) {
            $.ajax({
                url: '<?= site_url('home/get_available_slots') ?>',
                method: 'POST',
                data: {
                    tanggal: tanggal,
                    [csrfName]: csrfHash // pastikan selalu kirim token
                },
                success: function(res) {
                    const parsed = JSON.parse(res);
                    data = parsed.slots;
                    csrfHash = parsed.csrf_token; // update token baru dari server

                    let container = $('#slot_jam_container');
                    container.empty();

                    if (data.length === 0) {
                        container.html('<div class="col-12 text-center text-danger">Tidak ada slot tersedia.</div>');
                        return;
                    }

                    selectedSlots = [];

                    data.forEach((slot, i) => {
                        let col = $('<div class="col-md-3 col-6"></div>');
                        let btn = $(`<button type="button" class="btn w-100 mb-2 btn-sm text-center d-block"></button>`)
                            .addClass(slot.disabled ? 'btn-secondary disabled' : 'btn-outline-primary')
                            .html(slot.label)
                            .attr('data-value', slot.value);

                        if (!slot.disabled) {
                            btn.on('click', function() {
                                const val = slot.value;

                                if (selectedSlots.includes(val)) {
                                    selectedSlots = selectedSlots.filter(v => v !== val);
                                } else {
                                    selectedSlots.push(val);
                                }

                                updateAvailableSlots();
                            });
                        }

                        col.append(btn);
                        container.append(col);
                    });
                },
                error: function() {
                    Swal.fire("Gagal memuat slot!", "Coba lagi nanti.", "error");
                }
            });
        }

        function updateAvailableSlots() {
            $('#slot_jam_container button').each(function() {
                const val = $(this).data('value');
                const index = data.findIndex(slot => slot.value === val);
                const isSelected = selectedSlots.includes(val);

                $(this)
                    .removeClass('btn-primary active btn-outline-primary disabled')
                    .addClass(isSelected ? 'btn-primary active' : 'btn-outline-primary');

                if (
                    selectedSlots.length > 0 &&
                    !isSelected &&
                    ![
                        data[index - 1]?.value,
                        data[index + 1]?.value
                    ].some(v => selectedSlots.includes(v))
                ) {
                    $(this).addClass('disabled');
                }
            });

            $('#selected_jam').val(selectedSlots.join(','));
            $('#total_jam').val(selectedSlots.length * 2);
        }
    </script>

</body>

</html>