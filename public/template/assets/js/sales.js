$(document).ready(function () {

    $('#id_produk').on('change', function () {

        let id = $(this).val();

        if (id === '') {
            resetProduct();
            return;
        }

        loadProduct(id);

    });

    $('#qty').on('keyup change', function () {

        calculateSubtotal();

    });

});

/* ========================================= */

function loadProduct(id) {
    let url = '/sales/product/' + id;

    $.ajax({
        url: url,
        type: 'GET',

        success: function (response) {
            console.log(response);
            fillProduct(response);

        },

        error: function () {
            alert('Produk tidak ditemukan.');
            resetProduct();

        }

    });

}

/*  Menampilkan informasi produk */

function fillProduct(product) {
    console.log(product);
    $('#harga_jual').text(formatRupiah(product.harga_jual));
    $('#stok').text(product.stok);
    $('#satuan').text(product.satuan);
    $('#fraction').text(product.fraction);
    $('#harga_jual_value').val(product.harga_jual);
    $('#qty').attr('max', product.stok);

    calculateSubtotal();
}

$('#qty').on('input', function () {
    let qty = parseInt($(this).val()) || 0;
    let max = parseInt($(this).attr('max')) || 0;
    if (qty > max) {
        $(this).addClass('is-invalid');
        if ($(this).siblings('.invalid-feedback').length === 0) {
            $(this).after(
                '<div class="invalid-feedback">Qty melebihi stok yang tersedia.</div>'
            );
        }
    } else {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
    }

    calculateSubtotal();

});

/* perhitungan untuk SubTotal */

function calculateSubtotal() {
    let hargaJual = parseInt($('#harga_jual_value').val()) || 0;
    let qty = parseInt($('#qty').val()) || 0;
    let subtotal = hargaJual * qty;
    $('#subtotal').val(formatRupiah(subtotal));

}

/* ========================================= */

function resetProduct() {
    $('#harga_jual').text('-');
    $('#stok').text('-');
    $('#satuan').text('-');
    $('#fraction').text('-');
    $('#subtotal').val('');
    $('#harga_jual_value').val('');
    $('#fraction_value').val('');

}

/* ========================================= */

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);

}