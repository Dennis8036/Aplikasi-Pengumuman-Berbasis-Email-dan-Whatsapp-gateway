<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Include your CSS files here -->
    <link rel="stylesheet" href="path/to/your/styles.css">
    <style>
        .card {
            margin: 20px; /* Adjust margin as needed */
            padding: 20px; /* Add padding to the card */
            border-radius: 8px; /* Optional: for rounded corners */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Optional: for shadow effect */
        }
        .table-responsive {
            overflow-x: auto; /* Allow horizontal scroll if needed */
        }
        .table {
            min-width: 1200px; /* Ensure table is wide enough */
        }
    </style>
</head>
<body>
    <!-- Sidebar start -->
    <!-- Your sidebar code here -->
    <!-- Sidebar end -->

    <!-- Content body start -->

        <!-- row -->

       
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"></h4>

                           
                                <table class="table">
                    <form action="<?= base_url('Home/aksi_t_pengumuman') ?>" method="POST">
                        <!-- Hidden field untuk id_user -->
                        <input type="hidden" name="id_user" value="<?= session()->get('id_user'); ?>">

                        <div class="form-group row">
                            <label for="judul" class="col-sm-2 col-form-label">Judul Pengumuman</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="judul" placeholder="Masukkan judul pengumuman" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="isi" class="col-sm-2 col-form-label">Isi Pengumuman</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="isi" rows="5" placeholder="Masukkan isi pengumuman" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="target" class="col-sm-2 col-form-label">Tujuan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="tujuan" required>
                                    <option value="">Pilih Tujuan</option>
                                     <option value="Orang Tua Dan Siswa">Orang Tua Dan Siswa</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Siswa">Siswa</option>
                                </select>
                            </div>
                        </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>
