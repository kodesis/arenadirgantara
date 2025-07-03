<div class="head-login">
    <h3>Upload Bukti Pembayaran</h3>
    <p>Kode Booking: <strong><?= $booking->kode_booking ?></strong></p>
    <p>Silakan upload bukti pembayaran sebelum waktu berakhir.</p>
    <p>Batas waktu pembayaran: <span id="timer" class="text-danger fw-bold">00:00</span></p>
    <form action="<?= base_url('home/proses_upload_bukti/' . $booking->kode_booking) ?>" method="post" autocomplete="off" novalidate enctype="multipart/form-data">
        <div class="form-login">
            <div class="form-group">
                <label for="inputNominal">Nominal Pembayaran</label>
                <div class="input-group">
                    <input type="text" id="inputNominal" name="nominal" value="<?= $data_bayar['nominal'] ?>" class="d-none">
                    <input type="text" class="form-control" value="<?= number_format($data_bayar['nominal']) ?>" readonly required>
                    <button type="button" class="btn btn-sm btn-secondary copy-btn" onclick="copyToClipboard('inputNominal')">Salin</button>
                </div>
            </div>
            <div class="form-group">
                <label for="inputRekening">Transfer ke Rekening</label>
                <div class="input-group">
                    <input type="text" id="inputRekening" name="no_rekening" class="form-control" value="<?= ($data_bayar['nomor_rekening']) ?>" readonly required>
                    <button type="button" class="btn btn-sm btn-secondary copy-btn" onclick="copyToClipboard('inputRekening')">Salin</button>
                </div>
                <small class="form-text text-muted"><?= $data_bayar['keterangan'] ?></small>
            </div>
            <div class="form-group">
                <label for="bukti_transfer">Upload Bukti Transfer</label>
                <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-login">Upload Bukti</button>
            </div>
        </div>
    </form>
</div>


<script>
    // Countdown timer
    const expiredAt = new Date("<?= $booking->expired_at ?>").getTime();
    const timerEl = document.getElementById("timer");

    const countdown = setInterval(function() {
        const now = new Date().getTime();
        const distance = expiredAt - now;

        if (distance <= 0) {
            clearInterval(countdown);
            timerEl.innerHTML = "Expired";
            alert("Waktu upload sudah habis. Silakan booking ulang.");
            location.href = '<?= site_url('home') ?>';
            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        timerEl.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }, 1000);

    function copyToClipboard(id) {
        var input = document.getElementById(id);
        input.select();
        input.setSelectionRange(0, 99999); // Untuk mobile support

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        navigator.clipboard.writeText(input.value)
            .then(() => {
                // alert('Teks berhasil disalin!');
                Toast.fire({
                    icon: "success",
                    title: "Teks berhasil disalin!"
                });
            })
            .catch(err => {
                Toast.fire({
                    icon: "error",
                    title: 'Gagal menyalin: ' + err
                });
            });
    }
</script>