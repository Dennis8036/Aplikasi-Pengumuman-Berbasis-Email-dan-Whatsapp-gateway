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
            min-width: 1300px; /* Ensure table is wide enough */
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
                    
                    <form action="<?= base_url('Home/aksi_t_buku') ?>" method="POST">


<div class="form-group row">
    <label for="judul" class="col-sm-2 col-form-label">Nama Kategori</label>
    <div class="col-sm-10">
        <select class="form-control" name="kategori" required>
            <option value="">Pilih</option>
            <?php foreach($kategori as $dennis): ?>
                <option value="<?=$dennis->id_kategori?>">
                    <?=$dennis->nama_kategori?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>


                        <div class="form-group row">
                            <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Buku" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Penulis Buku" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Penerbit Buku" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tahunterbit" class="col-sm-2 col-form-label">Tahun Terbit</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="tahunterbit" name="tahun_terbit" placeholder="Tahun Terbit" required>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
 </form>
                            </table>
                        </div>
                    </div>
