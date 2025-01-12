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
                                <!-- General Form Elements -->
                        <form action="<?= base_url('Home/aksi_t_koleksi') ?>" method="POST" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Nama Koleksi</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="nk" value="<?= $kategori->nama_kategori ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="jd" value="<?= $buku->judul ?>" readonly>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Penulis</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="pn" value="<?= $buku->penulis ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Penerbit</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="pt" value="<?= $buku->penerbit ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputText" class="col-sm-2 col-form-label">Tahun Terbit</label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="" class="form-control" name="ter" value="<?= $buku->tahunterbit ?>" readonly>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>
