<div class="content">
    <div class="breadcrumb-wrapper">
        <!-- <h1>Booking</h1> -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb p-0">
                <li class="breadcrumb-item">Deposit</li>
                <li class="breadcrumb-item" aria-current="page">
                    Deposit History
                </li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Recent Order Table -->
            <div class="card card-table-border-none recent-orders" id="recent-orders">
                <div class="card-header card-header-border-bottom justify-content-between">
                    <h2>Deposit History</h2>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-hover nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>No. Resi</th>
                                <th>Tanggal</th>
                                <th>Koli</th>
                                <th>Chargeable</th>
                                <th>Nominal</th>
                                <th>Topup</th>
                                <th>Sisa saldo</th>
                            </tr>
                        </thead>
                        <tbody id="deposit-body">
                            <?php $this->load->view('pages/dashboard/deposit/v_deposit_history_row', ['deposits' => $deposits, 'offset' => $offset]); ?>
                        </tbody>
                    </table>

                    <div class="text-center mt-3">
                        <button id="loadMoreBtn" class="btn btn-primary" data-offset="<?= $limit ?>" data-total="<?= $total_rows ?>">
                            Load More
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>