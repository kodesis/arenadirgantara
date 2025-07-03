<!-- contact-area -->
<section class="contact__area">
    <div class="container">
        <!-- <div class="row">
            <div class="col-lg-5">
                <div class="contact__content">
                    <div class="section-title mb-35">
                        <h2 class="title">Booking details</h2>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <div class="blog__details-inner">
                    <div class="blog__details-inner-content">
                        <h4 class="title">Ketentuan Penggunaan Venue</h4>
                        <p>Berikut adalah peraturan yang wajib dipatuhi oleh seluruh pengguna Arena Dirgantara:</p>
                        <div class="about__list-box">
                            <ul class="list-wrap">
                                <li><i class="flaticon-arrow-button"></i>Disarankan menggunakan sepatu bola saat bermain di lapangan Arena Dirgantara.</li>
                                <li><i class="flaticon-arrow-button"></i>Wajib menjaga kebersihan di seluruh area venue.</li>
                                <li><i class="flaticon-arrow-button"></i>Wajib menjaga ketertiban dan sopan santun di lingkungan venue.</li>
                                <li><i class="flaticon-arrow-button"></i>Dilarang merokok di area lapangan Arena Dirgantara.</li>
                                <li><i class="flaticon-arrow-button"></i>Dilarang membawa senjata tajam, alkohol, atau obat-obatan terlarang ke dalam area venue.</li>
                                <li><i class="flaticon-arrow-button"></i>DILARANG KERAS meludah di dalam area venue.</li>
                                <li><i class="flaticon-arrow-button"></i>Dilarang bersandar atau menarik jaring pembatas lapangan.</li>
                                <li><i class="flaticon-arrow-button"></i>Jumlah maksimal pemain di dalam lapangan adalah 30 orang.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row justify-content-center gutter-24">
                    <div class="col-12">
                        <div class="services_checkout">
                            <div class="services__item-top">
                                <div class="services__icon-three">
                                    <i class="flaticon-target"></i>
                                </div>
                                <div class="services__top-title">
                                    <h2 class="title">Selected<br>slot</h2>
                                </div>
                            </div>
                            <div class="services__content-three">

                                <h5><?= format_indo($tanggal) ?></h5>
                                <div class="row mt-4">
                                    <?php if (is_array($selected_jam)) : ?>
                                        <?php foreach ($selected_jam as $s) : ?>
                                            <div class="col-md-6 mb-2">
                                                <div class="p-2 border rounded shadow-sm text-center bg-light">
                                                    <?= $s ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">

                <div class="contact__form-wrap">
                    <h2 class="title">Booking form</h2>
                    <p>Your data will not be published.</p>
                    <form action="<?= base_url('home/submit_booking') ?>" method="POST">
                        <input type="hidden" name="tanggal" id="tanggal_booking" value="<?= $tanggal ?>" readonly>
                        <input type="hidden" name="jam" id="selected_jam" value="<?= $slot ?>" readonly required>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-grp">
                                    <input type="text" name="nama" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-grp">
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-grp">
                                    <input type="text" name="no_hp" placeholder="Phone" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn">Process booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact-area-end -->