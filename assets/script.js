const flashdata = $(".flash-data").data("flashdata");
if (flashdata) {
    Swal.fire({
        title: "Success!! ",
        text: flashdata,
        icon: "success",
    });
}

const flashdata_error = $(".flash-data-error").data("flashdata");
if (flashdata_error) {
    Swal.fire({
        title: "Error!! ",
        text: flashdata_error,
        icon: "error",
    });
}

$(document).on('click', '.viewBooking', function () {
    var id = $(this).data('id');
    var nama = $(this).data('nama');

    $('#editData .modal-title').text(nama);

    $.ajax({
        url: "booking/detail",
        type: "POST",
        data: {
            id: id,
        },
        success: function (data) {
            $('#editData .edit').html(data);
            // ✅ Inisialisasi ulang select2 setelah form dimuat
            $('#editData .edit').find('.select2').select2({
                dropdownParent: $('#editData')
            });

            $('#editData .edit').find('.no-search').select2({
                minimumResultsForSearch: Infinity,
                dropdownParent: $('#editData')
            });

            $('#editData').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({
                title: "Error!! ",
                text: 'Gagal mengambil data',
                icon: "error",
            });
        }
    });
});


