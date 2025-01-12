<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Sewa Kamar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #ffffff;
        }
        .card-header {
            background-color: #ffffff;
            color: #000000;
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            box-shadow: none;
            border: 1px solid #ced4da;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 0.5rem;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Form Sewa Kamar</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Home/aksi_t_penghuni') ?>" method="POST" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">No Kamar</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="nokamar" value="<?= $kamar->no_kamar ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Harga Kamar / Bulan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="RP <?= number_format($kamar->harga_per_bulan, 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Nama Lengkap" class="form-control" name="nl" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">No KTP</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="No KTP" class="form-control" name="ktp" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Alamat Asal</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Alamat Asal" class="form-control" name="aa" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">No Telp/HP</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="No Telp/HP" class="form-control" name="no" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="periodeHuni" class="col-sm-2 col-form-label">Periode Huni</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                         <input type="text" class="form-control" id="tglh" name='tglh' value="<?= date('Y-m-d') ?>" readonly required style="background-color: #ffffff; border: 1px solid #ced4da; cursor: default;">
                                        <div class="">
                                            <span class="input-group-text">s/d</span>
                                        </div>
                                        <input type="date" class="form-control" id="tgla" name="tgla" required>
                                    </div>
                                    <small>Durasi sewa: <span id="totalBulan">0 Hari</span> </small>
                                </div>
                            </div>

    <div class="form-group row">
        <label for="inputText" class="col-sm-2 col-form-label">Jumlah Bayar</label>
        <div class="col-sm-10">
            <input type="hidden" id="hiddenJumlahBayar" name="hidden_bayar">
            <input type="text" placeholder="Total Bayar" class="form-control" id="jumlahBayar" name="bayar" required readonly style="background-color: #ffffff; border: 1px solid #ced4da; cursor: default;">
        </div>
    </div>

<div class="form-group row">
    <input type="hidden" name="tsb" value="0"> <!-- Total Sudah Bayar -->
</div>

<div class="form-group row">
    <input type="hidden" name="pu" value="0"> <!-- PI Utang -->
</div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk menghitung jumlah bayar berdasarkan periode huni -->
<script>
    document.getElementById('tglh').addEventListener('change', hitungJumlahBayar);
    document.getElementById('tgla').addEventListener('change', hitungJumlahBayar);

    function hitungJumlahBayar() {
        const hargaPerBulan = <?= $kamar->harga_per_bulan ?>; // Harga per bulan dari PHP
        const hargaPerHari = hargaPerBulan / 30; // Asumsi 1 bulan = 30 hari
        const tglh = new Date(document.getElementById('tglh').value);
        const tgla = new Date(document.getElementById('tgla').value);

        if (tglh && tgla && tgla > tglh) {
            const selisihWaktu = tgla - tglh; // Selisih waktu dalam milidetik
            const selisihHari = Math.ceil(selisihWaktu / (1000 * 60 * 60 * 24)); // Konversi ke hari
            const bulanPenuh = Math.floor(selisihHari / 30); // Hitung jumlah bulan penuh
            const sisaHari = selisihHari % 30; // Hitung sisa hari

            // Tampilkan jumlah bulan dan hari di UI
            document.getElementById('totalBulan').textContent = bulanPenuh + ' bulan ' + sisaHari + ' hari';

            // Hitung total bayar
            const totalBayar = (bulanPenuh * hargaPerBulan) + (sisaHari * hargaPerHari);
            
            // Update field jumlah bayar dan hidden input
            document.getElementById('jumlahBayar').value = "Rp " + new Intl.NumberFormat('id-ID').format(totalBayar);
            document.getElementById('hiddenJumlahBayar').value = totalBayar; // Simpan nilai numerik untuk submit
        }
    }
</script>

</body>
</html>
