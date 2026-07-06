$(document).ready(function () {

    // Reset form saat pertama kali halaman dibuka
    resetProduct();

    // Ketika produk dipilih
    $('#id_produk').on('change', function () {
        let id = $(this).val();

        // Reset Qty & Subtotal
        $('#qty').val('');
        $('#subtotal').val('');

        // Bersihkan validasi Qty
        $('#qty').removeClass('is-invalid');
        $('#qty').siblings('.invalid-feedback.dynamic').remove();

        if (id === '') {
            resetProduct();
            return;
        }

        loadProduct(id);

    });

    // Ketika Qty berubah
    $('#qty').on('input', function () {

        validateQty();

        calculateSubtotal();

    });

});

/* Mengambil data produk melalui AJAX */

function loadProduct(id) {
    $.ajax({
        url: '/stock_in/product/' + id,
        type: 'GET',
        success: function (response) {
            fillProduct(response);
        },

        error: function () {
            alert('Produk tidak ditemukan.');

            resetProduct();
        }
    });
}

/* Menampilkan informasi produk */

function fillProduct(product) {
    $('#harga_beli').text(formatRupiah(product.harga_beli));
    $('#stok').text(product.stok);
    $('#satuan').text(product.satuan);
    $('#fraction').text(product.fraction);
    // Simpan harga beli
    $('#harga_beli_value').val(product.harga_beli);
    // Validasi harga beli
    if (product.harga_beli <= 0) {
        alert(
            'Harga beli produk masih Rp 0.\n' +
            'Silakan update harga beli pada Master Produk terlebih dahulu.'
        );
        $('#qty').prop('disabled', true);
        $('button[type="submit"]').prop('disabled', true);
        return;
    }

    // Aktifkan kembali Qty & tombol Save
    $('#qty').prop('disabled', false);
    $('button[type="submit"]').prop('disabled', false);

    calculateSubtotal();

    $('#qty').focus();

}

/* Validasi Qty */


function validateQty() {

    let qty = parseInt($('#qty').val()) || 0;
    $('#qty').removeClass('is-invalid');
    $('#qty').siblings('.invalid-feedback.dynamic').remove();
    if (qty <= 0) {
        $('#qty').addClass('is-invalid');
        $('#qty').after(
            '<div class="invalid-feedback dynamic">' +
            'Qty harus lebih besar dari 0.' +
            '</div>'
        );
    }
}

/* Menghitung subtotal */

function calculateSubtotal() {
    let hargaBeli = parseInt($('#harga_beli_value').val()) || 0;
    let qty = parseInt($('#qty').val()) || 0;
    if (qty <= 0) {
        $('#subtotal').val('');
        return;
    }

    let subtotal = hargaBeli * qty;
    $('#subtotal').val(formatRupiah(subtotal));
}

/* Reset informasi produk */

function resetProduct() {
    $('#harga_beli').text('-');
    $('#stok').text('-');
    $('#satuan').text('-');
    $('#fraction').text('-');
    $('#harga_beli_value').val('');
    $('#fraction_value').val('');
    $('#qty').val('');
    $('#subtotal').val('');
    $('#qty').prop('disabled', true);
    $('button[type="submit"]').prop('disabled', true);
    $('#qty').removeClass('is-invalid');
    $('#qty').siblings('.invalid-feedback.dynamic').remove();
}

/* Format Rupiah */


function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}