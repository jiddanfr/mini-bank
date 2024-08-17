// Fungsi untuk menyimpan dan mengelola indeks baris aktifitas
function printSimpanan() {
    var nomorRekening = $('#nomor_rekening').val();
    var nominalSimpanan = $('#nominal_simpanan').val();
    nominalSimpanan = replaceDot(nominalSimpanan);

    var keteranganSimpanan = $('#keterangan_simpanan').val();

    if (nominalSimpanan === '' || keteranganSimpanan === '') {
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#FA5252',
                icon: {
                    className: 'bi bi-x-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'error',
            message: 'Nominal dan Keterangan tidak boleh kosong!'
        });
        return;
    }

    const nominalValue = parseInt(nominalSimpanan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#FA5252',
                icon: {
                    className: 'bi bi-x-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        notyf.open({
            type: 'error',
            message: 'Nominal tidak valid!'
        });
        return;
    }

    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    const formattedNominal = formatCurrency(nominalSimpanan);

    // Dapatkan indeks baris berdasarkan NIS
    const activityIndex = getActivityIndex(nomorRekening);

    const printContent = `
            <div style="font-size: 14px; position: absolute; top: ${activityIndex * 20}px;">
                <p>${tanggalSekarang}&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;${keteranganSimpanan}</p>
            </div>
        `;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
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

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    $('input[name=TxtNominalSimpanan]').val(nominalSimpanan);
    $('#simpanForm').submit();

    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [{
            type: 'info',
            background: '#0948B3',
            icon: {
                className: 'bi bi-check-circle-fill',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        }]
    });
    notyf.open({
        type: 'success',
        message: 'Simpan dan cetak berhasil!'
    });
}

function printPenarikan(nis) {
    var nomorRekening = $('#nomor_rekening').val();
    var nominalPenarikan = $('#nominal_penarikan').val();
    nominalPenarikan = replaceDot(nominalPenarikan);

    var keteranganPenarikan = $('#keterangan_penarikan').val();

    if (nominalPenarikan === '' || keteranganPenarikan === '') {
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#FA5252',
                icon: {
                    className: 'bi bi-x-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        return;
    }

    const nominalValue = parseInt(nominalPenarikan.replace(/\D/g, ''));
    if (isNaN(nominalValue) || nominalValue <= 0) {
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                type: 'error',
                background: '#FA5252',
                icon: {
                    className: 'bi bi-x-circle',
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }]
        });
        return;
    }

    const tanggalSekarang = new Date().toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric'
    });

    const formattedNominal = formatCurrency(nominalPenarikan);

    // Dapatkan indeks baris berdasarkan NIS
    const activityIndex = getActivityIndex(nis);

    const printContent = `
            <div style="font-size: 14px; position: absolute; top: ${activityIndex * 20}px;">
                <p>${tanggalSekarang}&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;${formattedNominal}&nbsp;&nbsp;${keteranganPenarikan}</p>
            </div>
        `;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
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

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    $('input[name=TxtNominalPenarikan]').val(nominalPenarikan);
    $('#penarikanForm').submit();

    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [{
            type: 'info',
            background: '#0948B3',
            icon: {
                className: 'bi bi-check-circle-fill',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        }]
    });
    notyf.open({
        type: 'success',
        message: 'Penarikan dan cetak berhasil!'
    });
}

function formatCurrency(value) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(value);
}

function getActivityIndex(nis) {
    const key = `activityIndex_${nis}`;
    let index = parseInt(localStorage.getItem(key)) || 0;
    index = (index % 20) + 1; // Sirkulasi antara 1 sampai 20
    localStorage.setItem(key, index);
    return index;
}

function replaceDot(value) {
    return value.replace(/\./g, '');
}
