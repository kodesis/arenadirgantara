<form id="formViewBooking" action="<?= $url_form ?>" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="fname">Name</label>
                            <input type="text" class="form-control" value="<?= $detail['nama'] ?>" placeholder="Name" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lname">Phone number</label>
                            <input type="text" class="form-control" value="<?= $detail['no_hp'] ?>" placeholder="Phone number" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lname">Booking date</label>
                            <input type="date" class="form-control" value="<?= $detail['tanggal'] ?>" placeholder="Booking date" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lname">Slot</label>
                            <input type="text" class="form-control" value="<?= $detail['jam_mulai']  . '-' . $detail['jam_selesai'] ?>" placeholder="Slot time" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="lname">Bukti Transfer</label>
                            <?php
                            if ($detail['status'] !== 'waiting_payment') {
                            ?>
                                <a href="<?= base_url('uploads/bukti_transfer/' . $detail['bukti_transfer']) ?>" target="_blank">
                                    <img src="<?= base_url('uploads/bukti_transfer/' . $detail['bukti_transfer']) ?>" class="w-100 img-thumbnail" alt="">
                                </a>

                            <?php
                            } else {
                            ?>
                                <h5 class="text-center mt-5"><?= strtoupper(str_replace('_', ' ', $detail['status'])) ?></h5>
                            <?php
                            }  ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="status" id="statusField">
                <input type="hidden" name="alasan_reject" id="alasanField">
                <input type="hidden" name="id_booking" value="<?= $detail['id'] ?>">

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">
                Close
            </button>
            <?php
            if ($detail['status'] == 'pending') {
            ?>
                <button type="button" id="btnReject" class="btn btn-warning btn-pill">
                    Reject
                </button>
                <button type="button" id="btnApprove" class="btn btn-primary btn-pill">
                    Approve
                </button>
            <?php
            } ?>
        </div>
    </div>
</form>