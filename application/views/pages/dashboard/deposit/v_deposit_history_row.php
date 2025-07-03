<?php $no = $offset + 1; ?>
<?php foreach ($deposits as $c) : ?>
    <?php if ($c->topup_date) : ?>
        <tr>
            <td class="text-end"><?= $no++ ?>.</td>
            <td class="text-center" colspan="5">Top Up Saldo <?= format_indo($c->topup_date) ?></td>
            <td class="text-end"><?= number_format($c->amount) ?></td>
            <td class="text-end"><?= number_format($c->sisa_saldo) ?></td>
        </tr>
    <?php else : ?>
        <tr>
            <td class="text-end"><?= $no++ ?>.</td>
            <td><?= $c->booking_code ?></td>
            <td><?= format_indo($c->tanggal_booking) ?></td>
            <td class="text-end"><?= number_format($c->koli) ?></td>
            <td class="text-end"><?= number_format($c->chargeable_weight) ?></td>
            <td class="text-end"><?= number_format($c->usage_saldo) ?></td>
            <td class="text-end">-</td>
            <td class="text-end"><?= number_format($c->sisa_saldo) ?></td>
        </tr>
    <?php endif; ?>
<?php endforeach; ?>