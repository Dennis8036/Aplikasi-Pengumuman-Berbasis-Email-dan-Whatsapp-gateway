<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
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
                        <h4 class="card-title mb-0">Form Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Home/aksi_t_pembayaran') ?>" method="POST" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">No Kamar</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="nokamar" value="<?= $join->no_kamar ?>" readonly >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="nl" value="<?= $join->nama ?>" readonly style="background-color: #ffffff; border: 1px solid #ced4da; cursor: default;">
                                </div>
                            </div>
                                    
                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">No KTP</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="nktp" value="<?= $join->no_ktp ?>" readonly style="background-color: #ffffff; border: 1px solid #ced4da; cursor: default;">
                                </div>
                            </div>
                                    
<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Total Bayar</label>
    <div class="col-sm-10">
        <input type="text" placeholder="Total Bayar" class="form-control" name="tp" value="RP <?= number_format($join->total_bayar, 0, ',', '.') ?>" readonly>
        <input type="hidden" name="total_bayar" value="<?= $join->total_bayar ?>"> <!-- Menyimpan nilai numerik -->
    </div>
</div>


                                    
<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Nominal Bayar</label>
    <div class="col-sm-10">
        <input type="text" id="nominal" placeholder="Input Nominal Uang" class="form-control" name="nb" required>
    </div>
</div>


                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tt" name='tt' value="<?= date('Y-m-d') ?>" readonly required style="background-color: #ffffff; border: 1px solid #ced4da; cursor: default;">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Keterangan" class="form-control" name="kt" required>
                                </div>
                            </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>
                                <!-- End General Form Elements -->

                                                                <script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/g);
        
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'RP ' + rupiah : '');
    }

    // Event listener untuk harga per bulan
    document.getElementById('nominal').addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'RP');
    });

    // Event listener untuk harga per tahun
    document.getElementById('harga_tahun').addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value, 'RP');
    });
</script>