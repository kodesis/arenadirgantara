<?php
// Dapatkan nomor halaman saat ini
$current_page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

// Hitung indeks data pertama pada halaman ini
// $start = ((($current_page - 1) * $per_page) + 1);
$start = ($total_rows) ? ((($current_page - 1) * $per_page) + 1) : '0';

// Hitung indeks data terakhir pada halaman ini
$end = min($current_page * $per_page, $total_rows);
?>
<div class="row bottom-information justify-content-between">
    <div class="col-12">
        <p class="mt-3 text-muted">Showing <span><?= $start ?></span> to <span><?= $end ?></span> of <span><?= $total_rows ?></span> entries</p>
        <?= $this->pagination->create_links() ?>
    </div>
</div>