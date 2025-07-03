<div class="content">
    <div class="breadcrumb-wrapper">
        <h1>Customer</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">
                    <a href="index.html">
                        <span class="mdi mdi-home"></span>
                    </a>
                </li>
                <li class="breadcrumb-item">Customer</li>
                <li class="breadcrumb-item" aria-current="page">
                    List customer
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-header card-header-border-bottom justify-content-between">
                    <h2>List Customer</h2>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddCustomer">
                        Add new customer
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-responsive-large table-hover" style="width: 100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Cust. Name</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Saldo deposit</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customers) {
                                $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * 10) + 1) : '1';

                                foreach ($customers as $c) :

                                    $saldo = $this->M_Deposit->getSaldoAkhirCustomer($c->id_user);
                                    $saldo_akhir = isset($saldo['saldo_akhir']) ? $saldo['saldo_akhir'] : 0; ?>
                                    <tr>
                                        <td class="text-right"><?= $no++ ?>.</td>
                                        <td><?= $c->name ?></td>
                                        <td><?= $c->address ?></td>
                                        <td><?= $c->whatsapp_number ?></td>

                                        <td class="text-right <?= ($saldo_akhir < 500000) ? 'bg-warning text-white' : 'bg-success text-white' ?>">
                                            Rp <?= number_format($saldo_akhir) ?>
                                        </td>
                                        <td class="text-left">
                                            <label class="switch switch-primary form-control-label">
                                                <input type="checkbox" class="switch-input form-check-input check_active" <?= ($c->is_active == '1') ? 'checked' : '' ?> id="checkbox_<?= $c->id_user ?>">
                                                <span class="switch-label"></span>
                                                <span class="switch-handle"></span>
                                            </label>
                                        </td>
                                        <td>

                                            <button type="button" class="btn btn-outline-primary btn-sm viewCustomer" data-id="<?= $c->id_user ?>" data-nama="<?= $c->name ?>">
                                                <i class="mdi mdi-pencil-box"></i> Edit
                                            </button>
                                            <a href="<?= base_url('deposit/index/' . $c->id_user) ?>" class="btn btn-outline-info btn-sm">
                                                <i class="mdi mdi-history"></i> Deposit
                                            </a>
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

<div class="modal fade" id="modalAddCustomer" tabindex="-1" role="dialog" aria-labelledby="modalAddCustomer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCustomerTitle">
                    Add New Customer
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formAddCustomer" action="<?= base_url('customer/create_customer') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter customer's name" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label for="whatsapp_number">Whatsapp number</label>
                                        <input type="text" class="form-control" name="whatsapp_number" id="whatsapp_number" aria-describedby="whatsapp_number" placeholder="Enter customer's whatsapp number" />
                                        <small id="whatsapp_number" class="form-text text-muted">ex: 081112345678</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" placeholder="Enter customer's address"></textarea>
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