function printSimpanan(nis) {
    var nominalSimpanan = $('#nominal_simpanan').val();
    nominalSimpanan = replaceDot(nominalSimpanan);
    console.log("Nominal Simpanan (raw):", $('#nominal_simpanan').val());
    console.log("Nominal Simpanan (cleaned):", nominalSimpanan);

    var keteranganSimpanan = $('#keterangan_simpanan').val();
    console.log("Keterangan Simpanan:", keteranganSimpanan);

    if (nominalSimpanan === '' || keteranganSimpanan === '') {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal dan Keterangan tidak boleh kosong!' });
        return;
    }

    const nominalValue = parseInt(nominalSimpanan.replace(/\D/g, ''), 10);
    console.log("Nominal Simpanan (parsed to integer):", nominalValue);

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
    console.log("No Rekening:", noRekening);
    var keterangan = $('#keterangan_simpanan').val();
    console.log("Keterangan (saat POST):", keterangan);

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
            console.log("Response dari server:", response);
            
            if (response.status == 'success') {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'success', message: response.message });

                const tanggalSekarang = new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric' });
                const formattedNominal = nominalValue;
                const saldoTotal = response.saldo_total; // Saldo total dari respons
                console.log("Saldo Total terbaru:", saldoTotal);

                const activityIndex = getActivityIndex(noRekening);
                console.log("Activity Index:", activityIndex);

                const printContent = `
                    <div style="font-size: 12px; position: absolute; top: ${activityIndex * 20}px;">
                        <table style="width: 100%; border-collapse: collapse; background-color: rgba(255, 255, 255, 0.5); table-layout: fixed;">
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 16%; text-align: left;">${tanggalSekarang}</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 19%; text-align: left;">Rp.${formattedNominal}</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 19%; text-align: center;">-</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 23%; text-align: left;">Rp.${saldoTotal}</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 23%; text-align: left;">${keteranganSimpanan}</td>
                                </tr>
                            </tbody>
                        </table>
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
                console.log("Error status dari server:", response.message);
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'error', message: response.message });
            }
        },
        error: function(xhr) {
            console.error("Error dari server:", xhr);
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

    // Tambahkan console.log untuk memeriksa nilai input
    console.log("Nominal Penarikan (raw):", nominalPenarikan);
    console.log("Keterangan Penarikan:", keteranganPenarikan);

    if (nominalPenarikan === '' || keteranganPenarikan === '') {
        const notyf = new Notyf({
            position: { x: 'right', y: 'top' },
            types: [{ type: 'error', background: '#FA5252', icon: { className: 'bi bi-x-circle', tagName: 'span', color: '#fff' }, dismissible: false }]
        });
        notyf.open({ type: 'error', message: 'Nominal dan Keterangan tidak boleh kosong!' });
        return;
    }

    const nominalValue = parseInt(nominalPenarikan.replace(/\D/g, ''), 10);
    console.log("Nominal Value (parsed):", nominalValue);

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
            console.log("AJAX Response:", response);

            if (response.status === 'success') {
                const notyf = new Notyf({
                    position: { x: 'right', y: 'top' },
                    types: [{ type: 'info', background: '#0948B3', icon: { className: 'bi bi-check-circle-fill', tagName: 'span', color: '#fff' }, dismissible: false }]
                });
                notyf.open({ type: 'success', message: response.message });

                $('#penarikanForm')[0].reset();

                const tanggalSekarang = new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric' });
                const formattedNominal = nominalValue;
                const saldoTotal = response.saldo_total; 

                const activityIndex = getActivityIndex(nomorRekening); // Ganti noRekening dengan nomorRekening
                console.log("Posisi penarikan: ", activityIndex);

                const printContent = `
                    <div style="font-size: 12px; position: absolute; top: ${activityIndex * 20}px; ">
                        <table style="width: 100%; border-collapse: collapse; background-color: rgba(255, 255, 255, 0.5); table-layout: fixed;">
                            <tbody>
                                <tr>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 16%; text-align: left;">${tanggalSekarang}</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 19%; text-align: center;">-</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 19%; text-align: left;">Rp.${formattedNominal}</td>                                    
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 23%; text-align: left;">Rp.${saldoTotal}</td>
                                    <td style="border: 1px solid rgba(0, 0, 0, 0); padding: 8px; width: 23%; text-align: left;">${keteranganPenarikan}</td>
                                </tr>
                            </tbody>
                        </table>
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
            console.log("AJAX Error:", errorMessage);
            alert(errorMessage);
        }
    });
}



function getActivityIndex(nis) {
    const key = `activityIndex_${nis}`;
    let index = parseInt(localStorage.getItem(key), 10);

    // Jika index tidak valid (NaN atau undefined), atur ke 0
    if (isNaN(index) || index < 0) {
        index = 0;
    }

    // Tambahkan 1 ke indeks
    index += 1;

    // Jika indeks melebihi 30, kembali ke 1
    if (index > 28) {
        index = 1;
    }

    // Simpan nilai baru ke localStorage
    localStorage.setItem(key, index);

    // Tambahkan console.log untuk melihat index saat ini
    console.log("Activity Index saat ini: ", index);
    console.log("Nis saat ini: ", nis);
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
            console.log("NIS diinput (Simpanan):", nis); // Debug NIS yang diinput

            $.ajax({
                url: "index.php/ambil-data-nasabah", // Ganti dengan route yang sesuai
                type: 'POST', // Atau 'POST' jika sesuai
                data: {
                    _token: $('input[name="_token"]').val(), // CSRF token
                    TxtNoRekening: nis
                },
                success: function(response) {
                    console.log("Response dari server (Simpanan):", response); // Debug respons dari server

                    
                    var result = '<div class="alert alert-info mt-2">' +
                                    '<p><strong>Nama:</strong> ' + response.namanasabah + '</p>' +
                                    '<p><strong>Kelas:</strong> ' + response.kelasnasabah + '</p>' +
                                    '</div>';
                    $('#result').html(result); // Tampilkan hasil di bawah input
                    $('#nominal_simpanan').focus();
                },
                error: function(xhr) {
                    console.error("Error dari server (Simpanan):", xhr); // Debug error dari server
                    $('#result').html('<div class="alert alert-danger mt-2">Terjadi kesalahan: ' + xhr.statusText + '</div>');
                }
            });
        }
    });

    $('#no_rekening_penarikan').on('keypress', function(e) {
        if (e.which == 13) { 
            e.preventDefault(); 
            var nis = $(this).val();
            console.log("NIS diinput (Penarikan):", nis); 

            $.ajax({
                url: "index.php/ambil-data-nasabah", 
                type: 'POST', 
                data: {
                    _token: $('input[name="_token"]').val(), 
                    TxtNoRekening: nis
                },
                success: function(response) {
                    console.log("Response dari server (Penarikan):", response); 
                    
                    // Hapus bagian yang berhubungan dengan activityIndex
                    var result = '<div class="alert alert-info mt-2">' +
                                    '<p><strong>Nama:</strong> ' + response.namanasabah + '</p>' +
                                    '<p><strong>Kelas:</strong> ' + response.kelasnasabah + '</p>' +
                                    '</div>';
                    $('#result2').html(result); 
                    $('#nominal_penarikan').focus();
                },
                error: function(xhr) {
                    console.error("Error dari server (Penarikan):", xhr); 
                    $('#result2').html('<div class="alert alert-danger mt-2">Terjadi kesalahan: ' + xhr.statusText + '</div>');
                }
            });
        }
    });
});



