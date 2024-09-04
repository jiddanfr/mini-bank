function printSimpanan() {
    var nomorRekening = $('#nomor_rekening').val();
    var nominalSimpanan = $('#nominal_simpanan').val();
    nominalSimpanan = replaceDot(nominalSimpanan);

    var keteranganSimpanan = $('#keterangan_simpanan').val();

    if (nominalSimpanan === '' || keteranganSimpanan === '') {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal dan Keterangan tidak boleh kosong!' });
        return;
    }

    const nominalValue = parseInt(nominalSimpanan.replace(/\D/g, ''), 10);
    if (isNaN(nominalValue) || nominalValue <= 0) {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal tidak valid!' });
        return;
    }

    $('input[name=TxtNominalSimpanan]').val(nominalValue);
    
    var noRekening = $('#no_rekening').val();
    var keterangan = $('#keterangan_simpanan').val();

    // Ambil saldo total terbaru setelah transaksi dari database
    $.ajax({
        url: $('#simpanForm').attr('action'),
        method: 'POST',
        data: {
            _token: $('input[name="_token"]').val(),
            TxtNoRekening: noRekening,
            TxtNominalSimpanan: nominalValue,
            keterangan: keterangan
        },
        success: function(response) {
            if (response.status == 'success') {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'success', message: response.message });

                const tanggalSekarang = new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric' });
                const formattedNominal = formatCurrency(nominalValue);
                const saldoTotal = formatCurrency(response.saldo_total); // Saldo total dari respons

                const printContent = `
                    <div style="font-size: 14px; position: absolute;">
                        <p>${tanggalSekarang}&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${saldoTotal}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${keteranganSimpanan}</p>
                    </div>
                `;

                var bodyContent = $('body').html();
                $('body').html(`
                    <html>
                    <head>
                        <title>Print Simpanan</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; position: relative; height: 400px; }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                    </html>
                `);
                window.print();
                $('body').html(bodyContent);

            } else {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'error', message: response.message });
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var errorMessage = 'Terjadi kesalahan:\n';
            $.each(errors, function(key, value) {
                errorMessage += '- ' + value[0] + '\n';
            });
            alert(errorMessage);
        }
    });
}


function printPenarikan(nis) {
    var nomorRekening = $('#no_rekening_penarikan').val();
    var nominalPenarikan = $('#nominal_penarikan').val();
    nominalPenarikan = replaceDot(nominalPenarikan);

    var keteranganPenarikan = $('#keterangan_penarikan').val();

    if (nominalPenarikan === '' || keteranganPenarikan === '') {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal dan Keterangan tidak boleh kosong!' });
        return;
    }

    const nominalValue = parseInt(nominalPenarikan.replace(/\D/g, ''), 10);
    if (isNaN(nominalValue) || nominalValue <= 0) {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal tidak valid!' });
        return;
    }

    // Lakukan AJAX request
    $.ajax({
        url: $('#penarikanForm').attr('action'),
        method: 'POST',
        data: {
            _token: $('input[name="_token"]').val(), // CSRF token
            TxtNoRekening: nomorRekening,
            TxtNominalPenarikan: nominalValue,
            keterangan: keteranganPenarikan
        },
        success: function(response) {
            if(response.status === 'success') {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'success', message: response.message });

                $('#penarikanForm')[0].reset();

                const tanggalSekarang = new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric' });
                const formattedNominal = formatCurrency(nominalValue);
                const saldoTotal = formatCurrency(response.saldo_total); // Saldo total dari respons

                const activityIndex = response.aktivitas_count;
                const printContent = `
                    <div style="font-size: 14px; position: absolute; top: ${activityIndex * 20}px;">
                        <p>${tanggalSekarang}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;${saldoTotal}&nbsp;&nbsp;${keteranganPenarikan}</p>
                    </div>
                `;

                var bodyContent = $('body').html();
                $('body').html(`
                    <html>
                    <head>
                        <title>Print Penarikan</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; position: relative; height: 400px; }
                        </style>
                    </head>
                    <body>
                        ${printContent}
                    </body>
                    </html>
                `);
                window.print();
                $('body').html(bodyContent);

            } else {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'error', message: response.message });
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var errorMessage = 'Terjadi kesalahan:\n';
            $.each(errors, function(key, value) {
                errorMessage += '- ' + value[0] + '\n';
            });
            alert(errorMessage);
        }
    });
}



function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

function getActivityIndex(nis) {
    const key = `activityIndex_${nis}`;
    let index = parseInt(localStorage.getItem(key), 10) || 0;
    index = (index % 20) + 1; // Sirkulasi antara 1 sampai 20
    localStorage.setItem(key, index);
    return index;
}

function replaceDot(value) {
    return value.replace(/\./g, '');
}

$(document).ready(function() {
    $('#no_rekening').on('keypress', function(e) {
        if (e.which == 13) { // 13 adalah kode untuk tombol Enter
            e.preventDefault(); // Mencegah form submit default
            var nis = $(this).val();
            $.ajax({
                url: "index.php/ambil-data-nasabah", // Ganti dengan route yang sesuai
                type: 'POST', // Atau 'POST' jika sesuai
                data: {
                    _token: $('input[name="_token"]').val(), // CSRF token
                    TxtNoRekening: nis
                },
                success: function(response) {
                    // Asumsi respons adalah objek JSON
                    var result = '<div class="alert alert-info mt-2">' +
                                    '<p><strong>Nama:</strong> ' + response.namanasabah + '</p>' +
                                    '<p><strong>Kelas:</strong> ' + response.kelasnasabah + '</p>' +
                                    '</div>';
                    $('#result').html(result); // Tampilkan hasil di bawah input
                    $('#nominal_simpanan').focus();
                },
                error: function(xhr) {
                    $('#result').html('<div class="alert alert-danger mt-2">Terjadi kesalahan: ' + xhr.statusText + '</div>');
                }
            });
        }
    });
    $('#no_rekening_penarikan').on('keypress', function(e) {
        if (e.which == 13) { // 13 adalah kode untuk tombol Enter
            e.preventDefault(); // Mencegah form submit default
            var nis = $(this).val();
            $.ajax({
                url: "index.php/ambil-data-nasabah", // Ganti dengan route yang sesuai
                type: 'POST', // Atau 'POST' jika sesuai
                data: {
                    _token: $('input[name="_token"]').val(), // CSRF token
                    TxtNoRekening: nis
                },
                success: function(response) {
                    // Asumsi respons adalah objek JSON
                    var result = '<div class="alert alert-info mt-2">' +
                                    '<p><strong>Nama:</strong> ' + response.namanasabah + '</p>' +
                                    '<p><strong>Kelas:</strong> ' + response.kelasnasabah + '</p>' +
                                    '</div>';
                    $('#result2').html(result); // Tampilkan hasil di bawah input                    
                    $('#nominal_penarikan').focus();
                },
                error: function(xhr) {
                    $('#result2').html('<div class="alert alert-danger mt-2">Terjadi kesalahan: ' + xhr.statusText + '</div>');
                }
            });
        }
    });
});
