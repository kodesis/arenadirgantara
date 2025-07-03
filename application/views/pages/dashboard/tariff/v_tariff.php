<div class="content">
    <div class="breadcrumb-wrapper">
        <h1>Tariff</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">Tariff</li>
                <li class="breadcrumb-item" aria-current="page">
                    List Tariff
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-header card-header-border-bottom justify-content-between">
                    <h2>List Tariff</h2>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddTariff">
                        Add new tariff
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-responsive-large table-hover" style="width: 100%">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Origin</th>
                                <th class="text-center">Dest.</th>
                                <th class="text-center">Airline Code</th>
                                <th class="text-center">Price per kg</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($tariffs) {
                                $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * 10) + 1) : '1';

                                foreach ($tariffs as $t) : ?>
                                    <tr>
                                        <td class="text-right"><?= $no++ ?>.</td>
                                        <td><?= $t->origin ?></td>
                                        <td><?= $t->destination ?></td>
                                        <td><?= $t->airline_code ?></td>
                                        <td class="text-right"><?= number_format($t->price_per_kg) ?></td>
                                        <td class="text-center">
                                            <label class="switch switch-primary form-control-label">
                                                <input type="checkbox" class="switch-input form-check-input check_active" <?= ($t->is_active == '1') ? 'checked' : '' ?> id="checkbox_<?= $t->id ?>">
                                                <span class="switch-label"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm editData" data-id="<?= $t->id ?>" data-nama="<?= $t->origin . '-' . $t->destination . ' ' . $t->airline_code ?>">Edit</button>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            } else { ?>
                                <tr>
                                    <td colspan="6">Tidak ada data yang ditampilkan</td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                    <?php $this->load->view('layouts/dashboard/_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddTariff" tabindex="-1" role="dialog" aria-labelledby="modalAddTariff" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddTariffTitle">
                    Add New Tariff
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formAddTariff" action="<?= base_url('tariff/store_tariff') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="origin">Asal</label>
                                        <select name="origin" id="origin" class="form-control no-search" style="width: 100%;">
                                            <option value="CGK">CGK - Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="destination">Tujuan</label>
                                        <select name="destination" id="destination" class="form-control select2" style="width: 100%;" required>
                                            <option value="" disabled selected>:: Pilih Tujuan</option>
                                            <?php
                                            foreach ($destinations as $d) : ?>
                                                <option value="<?= $d->destination ?>"><?= $d->destination ?> - <?= $d->city ?></option>
                                            <?php
                                            endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih tujuan.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="airline">Maskapai</label>
                                        <select name="airline" id="airline" class="form-control no-search" style="width: 100%;" required>
                                            <option value="" disabled selected>:: Pilih maskapai</option>
                                            <option value="Garuda Indonesia">Garuda Indonesia</option>
                                            <option value="Lion Air Group">Lion Air Group</option>
                                            <option value="Pelita Air">Pelita Air</option>
                                        </select>
                                        <div class="invalid-feedback">Silakan pilih maskapai.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="price_per_kg">Price per kg</label>
                                        <input type="text" name="price_per_kg" id="price_per_kg" class="form-control" placeholder="Masukkan harga per kg" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Harap isi
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">
                        Close
                    </button>
                    <!-- <button type="submit" class="ladda-button btn btn-primary btn-pill btn-submit" data-style="expand-left">
                        <span class="ladda-label">Submit!</span>
                        <span class="ladda-spinner"></span>
                    </button> -->

                    <button type="submit" class="ladda-button btn btn-primary btn-pill btn-confirm" data-style="expand-left">
                        <span class="ladda-label">Submit!</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>