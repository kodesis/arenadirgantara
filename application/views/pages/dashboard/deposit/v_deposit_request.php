<div class="content">
    <div class="breadcrumb-wrapper">
        <!-- <h1>Booking</h1> -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">Deposit</li>
                <li class="breadcrumb-item" aria-current="page">
                    List Deposit Request
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-header card-header-border-bottom justify-content-between">
                    <h2>List Deposit Request</h2>
                    <?php
                    if ($this->session->userdata('role') == 'customer') { ?>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalRequestTopup">
                            Request top up
                        </button>
                    <?php
                    } ?>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-responsive-large table-hover nowrap no-footer" style="width: 100%">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Tanggal Request</th>
                                <th>Nominal</th>
                                <?php
                                if ($this->session->userdata('role') == 'admin') { ?>
                                    <th>Agen</th>
                                <?php
                                } ?>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($deposits) {
                                $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * 10) + 1) : '1';

                                foreach ($deposits as $t) : ?>
                                    <tr>
                                        <td class="text-right"><?= $no++ ?>.</td>
                                        <td><?= format_indo($t->request_date) ?></td>
                                        <td class="text-right"><?= number_format($t->amount) ?></td>
                                        <?php
                                        if ($this->session->userdata('role') == 'admin') { ?>
                                            <td><?= $t->name ?></td>
                                        <?php
                                        } ?>
                                        <td>
                                            <?php
                                            $status_badges = [
                                                'rejected' => ['text' => 'Rejected', 'color' => 'badge-danger'],
                                                'approved' => ['text' => 'Approved', 'color' => 'badge-success'],
                                                'pending' => ['text' => 'Pending', 'color' => 'badge-warning'],
                                            ];

                                            if (isset($status_badges[$t->status])) {
                                                $status = $status_badges[$t->status]; ?>
                                                <span class="badge <?= $status['color']; ?> w-100"><?= $status['text']; ?></span>
                                            <?php
                                            } ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($this->session->userdata('role') == 'admin') {
                                                if ($t->status == "pending") { ?>
                                                    <button type="button" class="btn btn-primary btn-sm viewRequestDeposit" data-id="<?= $t->id_request ?>">View</button>
                                                <?php
                                                } ?>
                                            <?php
                                            } ?>
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

<?php
if ($this->session->userdata('role') == 'customer') { ?>
    <div class="modal fade" id="modalRequestTopup" tabindex="-1" role="dialog" aria-labelledby="modalRequestTopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRequestTopupTitle">
                        Request top up
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formRequestTopup" action="<?= base_url('deposit/submit_request') ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input type="text" class="form-control" name="nominal" id="nominal" placeholder="Enter  nominal" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="transfer_date">Tanggal</label>
                                            <input type="date" class="form-control" name="transfer_date" id="transfer_date" aria-describedby="transfer_date" placeholder="Enter customer's whatsapp number" required />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="bukti_transfer">Bukti Transfer</label>
                                            <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control-file" required>
                                            <div class="invalid-feedback" id="bukti_transfer_feedback">
                                                File harus berupa PDF atau gambar (jpg, jpeg, png, gif).
                                            </div>
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
            </div>
        </div>
    </div>
<?php
} ?>



<script>
    document.getElementById('bukti_transfer').addEventListener('change', function() {
        const fileInput = this;
        const file = fileInput.files[0];
        const feedback = document.getElementById('bukti_transfer_feedback');

        // Reset state dulu
        fileInput.classList.remove('is-invalid');
        feedback.style.display = 'none';

        if (file) {
            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif'];
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                fileInput.classList.add('is-invalid');
                feedback.style.display = 'block';
                fileInput.value = ''; // reset file
            }
        }
    });
</script>