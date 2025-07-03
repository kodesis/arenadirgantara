<div class="content">
    <div class="breadcrumb-wrapper">
        <h1>Booking</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-item">Booking</li>
                <li class="breadcrumb-item" aria-current="page">
                    Create New Booking
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-body pt-4 pb-5">
                    <form method="post" action="<?= base_url('booking/store_booking') ?>" id="formAddBooking">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fname">Jenis pengiriman</label>
                                    <select name="jenis_pengiriman" id="jenis_pengiriman" class="form-control no-search" required>
                                        <option value="D">Domestik</option>
                                        <option value="I">Internasional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fname">Jenis Layanan</label>
                                    <select name="service" id="service" class="form-control no-search" required>
                                        <?php
                                        foreach ($services as $s) : ?>
                                            <option value="<?= $s->service_name ?>"><?= $s->service_name ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fname">Maskapai</label>
                                    <select name="airline" id="airline" class="form-control no-search" required>
                                        <option value="" disabled selected>:: Pilih maskapai</option>
                                        <?php
                                        foreach ($airlines as $s) : ?>
                                            <option value="<?= $s->airline_name ?>"><?= $s->airline_name ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Berat Timbang</label>
                                    <input type="text" name="berat_timbang" id="berat_timbang" class="form-control" placeholder="Masukkan berat timbang" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Total Koli</label>
                                    <input type="text" name="total_qty" id="total_qty" class="form-control" placeholder="Masukkan jumlah barang" value="1" readonly required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Total Volume</label>
                                    <input type="text" name="total_volume" id="total_volume" class="form-control" value="0" readonly required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Chargeable</label>
                                    <input type="text" name="chargeable" id="chargeable" class="form-control" value="0" readonly required>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <h6 class="mb-3">Input dimensi</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Panjang</th>
                                    <th>Lebar</th>
                                    <th>Tinggi</th>
                                    <th>Koli</th>
                                    <th>Volume</th>
                                    <th>delete</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <tr class="baris ">
                                    <td class="nomor-urut"></td>
                                    <td>
                                        <input type="text" name="panjang[]" id="panjang[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="lebar[]" id="lebar[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="tinggi[]" id="tinggi[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="jumlah[]" id="jumlah[]" class="form-control" value="1">
                                    </td>
                                    <td>
                                        <input type="text" name="volume[]" id="volume[]" class="form-control" value="0" readonly>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn-close hapusRow"><i class="mdi mdi-close"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="text-end">
                                        <button type="button" class="btn btn-secondary btn-sm" id="addRow">Add new row</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <h6 class="mb-3">Tentukan rute</h6>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Origin</label>
                                    <select name="origin" id="origin" class="form-control no-search" required>
                                        <option value="CGK">CGK - Jakarta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Destination</label>
                                    <select name="destination" id="destination" class="form-control select2" required>
                                        <option value="" disabled selected>:: Pilih tujuan</option>
                                        <?php
                                        foreach ($destinations as $s) : ?>
                                            <option value="<?= $s->destination ?>"><?= $s->destination . ' - ' . $s->city ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Price per kg</label>
                                    <input type="text" name="harga" id="harga" class="form-control" value="0" readonly required>

                                    <div class="valid-feedback">Harga ditemukan.</div>
                                    <div class="invalid-feedback">Harga tidak ditemukan.</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Total</label>
                                    <input type="text" name="nominal" id="nominal" class="form-control" value="0" readonly required>
                                </div>
                            </div>

                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Commodity</label>
                                    <input type="text" name="commodity" id="commodity" class="form-control" placeholder="Masukkan commodity" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="fname">Payment Method</label>
                                    <select name="payment_method" id="payment_method" class="form-control no-search" required> v
                                        <option value="" disabled selected>:: Pilih metode bayar</option>
                                        <?php
                                        foreach ($payment_methods as $s) : ?>
                                            <option value="<?= $s->nama_metode ?>"><?= $s->nama_metode . (($s->keterangan) ? ' - ' . $s->keterangan : '') ?></option>
                                        <?php
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer pt-5 border-top">
                            <a href="<?= base_url('booking') ?>" class="btn btn-warning text-white">Back</a>
                            <button type="submit" class="btn btn-primary btn-default">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>