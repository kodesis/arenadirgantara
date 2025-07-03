<form id="formRequestDeposit" action="<?= $url_form ?>" method="post">
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Enter nominal" value="<?= number_format($detail['amount']) ?>" readonly required />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="transfer_date">Tanggal</label>
                            <input type="date" class="form-control" name="transfer_date" id="transfer_date" aria-describedby="transfer_date" placeholder="Enter customer's whatsapp number" value="<?= $detail['transfer_date'] ?>" readonly required />
                        </div>
                    </div>
                    <div class="col-12">
                        <?php
                        $proof = $detail['transfer_proof'];
                        $extension = strtolower(pathinfo($proof, PATHINFO_EXTENSION)); ?>

                        <div class="form-group">
                            <label for="bukti_transfer">Bukti Transfer</label>
                            <?php if (in_array($extension, ['jpg', 'jpeg', 'png'])) : ?>
                                <img src="<?= base_url($proof) ?>" class="img-fluid border" alt="Bukti Transfer">
                            <?php elseif ($extension === 'pdf') : ?>
                                <embed src="<?= base_url($proof) ?>" type="application/pdf" width="100%" height="300px" />
                            <?php else : ?>
                                <a href="<?= base_url($proof) ?>" target="_blank">Lihat Bukti Transfer</a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Close
        </button>
        <button type="button" class="btn btn-danger" onclick="processDeposit('reject', <?= $detail['id'] ?>)">Reject</button>
        <button type="button" class="btn btn-primary" onclick="processDeposit('approve', <?= $detail['id'] ?>)">Approve</button>
    </div>
</form>