<form id="formAddTariff" action="<?= $url_form ?>" method="post">
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
                                    <option <?= ($d->destination == $destination) ? 'selected' : '' ?> value="<?= $d->destination ?>"><?= $d->destination ?> - <?= $d->city ?></option>
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
                                <option <?= ($airline_code == "Garuda Indonesia") ? 'selected' : '' ?> value="Garuda Indonesia">Garuda Indonesia</option>
                                <option <?= ($airline_code == "Lion Air Group") ? 'selected' : '' ?> value="Lion Air Group">Lion Air Group</option>
                                <option <?= ($airline_code == "Pelita Air") ? 'selected' : '' ?> value="Pelita Air">Pelita Air</option>
                            </select>
                            <div class="invalid-feedback">Silakan pilih maskapai.</div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="price_per_kg">Price per kg</label>
                            <input type="text" name="price_per_kg" id="price_per_kg" class="form-control" placeholder="Masukkan harga per kg" value="<?= number_format($price_per_kg) ?>" required>
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
        <button type="submit" class="ladda-button btn btn-primary btn-pill" data-style="expand-left">
            <span class="ladda-label">Submit!</span>
            <span class="ladda-spinner"></span>
        </button>
    </div>
</form>