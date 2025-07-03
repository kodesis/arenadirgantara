<div class="content">
    <!-- <div class="breadcrumb-wrapper">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">Booking</li>
                <li class="breadcrumb-item" aria-current="page">
                    List Booking
                </li>
            </ol>
        </nav>
    </div> -->

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Booking Code</th>
                                    <th>Booking Date</th>
                                    <th>Slot</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($bookings) {
                                    $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * 10) + 1) : '1';

                                    foreach ($bookings as $t) :

                                ?>
                                        <tr>
                                            <td class="text-right"><?= $no++ ?>.</td>
                                            <td><?= $t->kode_booking ?></td>
                                            <td><?= format_indo($t->tanggal) ?></td>
                                            <td class="text-right"><?= $t->jam_mulai . '-' . $t->jam_selesai ?></td>
                                            <td class="text-right"><?= number_format($t->harga) ?></td>
                                            <td>
                                                <?php
                                                $status_badges = [
                                                    'expired' => ['text' => 'Expired', 'color' => 'badge-dark'],
                                                    'rejected' => ['text' => 'Rejected', 'color' => 'badge-danger'],
                                                    'confirmed' => ['text' => 'Confirmed', 'color' => 'badge-success'],
                                                    'pending' => ['text' => 'Pending', 'color' => 'badge-warning'],
                                                    'waiting_payment' => ['text' => 'Waiting payment', 'color' => 'badge-light'],
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
                                                ?>
                                                    <button type="button" class="btn btn-primary btn-sm viewBooking" data-id="<?= $t->id ?>" data-nama="<?= $t->kode_booking ?>">View</button>
                                                <?php
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                } else { ?>
                                    <tr>
                                        <td colspan="7">Tidak ada data yang ditampilkan</td>
                                    </tr>
                                <?php
                                } ?>

                            </tbody>
                        </table>
                    </div>
                    <?php $this->load->view('layouts/dashboard/_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="editData" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="edit">
            </div>
        </div>
    </div>
</div>