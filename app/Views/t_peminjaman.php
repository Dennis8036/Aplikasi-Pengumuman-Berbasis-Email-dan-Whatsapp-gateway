<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Buku</title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="path/to/your/styles.css">
    <style>
        .card {
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            min-width: 1200px;
        }
    </style>
</head>
<body>
    <!-- Sidebar start -->
    <!-- Your sidebar code here -->
    <!-- Sidebar end -->

    <!-- Content body start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  
                    <table class="table">
                        <!-- General Form Elements -->
                        <form action="<?= base_url('Home/aksi_t_peminjaman') ?>" method="POST">

                            <!-- Hidden field untuk id_user -->
                            <input type="hidden" name="id_user" value="<?= session()->get('id_user'); ?>">

                            <div class="form-group row">
                                <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_buku" required>
                                        <option value="">Pilih</option>
                                        <?php foreach($buku as $item): ?>
                                            <option value="<?= $item->id_buku ?>">
                                                <?= $item->judul ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

<div class="form-group row">
    <label for="tanggalpeminjaman" class="col-sm-2 col-form-label">Tanggal Peminjaman</label>
    <div class="col-sm-10">
        <input type="date" class="form-control" name="tanggalpeminjaman" id="tanggalpeminjaman" readonly style="background-color: white;">
    </div>
</div>

                            <div class="form-group row">
                                <label for="tanggalpengembalian" class="col-sm-2 col-form-label">Tanggal Pengembalian</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tanggalpengembalian" required>
                                </div>
                            </div>

<div class="form-group row">
    <label for="statuspeminjaman" class="col-sm-2 col-form-label">Status Peminjaman</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="statuspeminjaman" value="Dipinjam" readonly style="background-color: white;">
    </div>
</div>



                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </table>
                </div>
            </div>
            <!-- End General Form Elements -->
        </div>
    </div>
</body>
</html>

<script>
    var today = new Date();
    today.setHours(24, 0, 0, 0); // Set waktu ke 24:00 (tengah malam)
    var date = today.toISOString().split('T')[0]; // Mengambil hanya bagian tanggal (YYYY-MM-DD)
    document.getElementById('tanggalpeminjaman').value = date; // Menetapkan tanggal ke input
</script>
