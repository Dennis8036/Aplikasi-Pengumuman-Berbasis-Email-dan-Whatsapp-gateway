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
                                <!-- General Form Elements -->
                                <form action="<?= base_url('Home/aksi_t_dokumen') ?>" method="POST" enctype="multipart/form-data">


<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Judul Dokumen</label>
    <div class="col-sm-10">
        <input type="text" id="" placeholder="Judul Dokumen" class="form-control" name="jd" required>
    </div>
</div>

                                      <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Kategori Dokumen</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Kategori Dokumen" class="form-control" name='kd'required>
                                        </div>
                                    </div>
                                    
<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Tanggal Post</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name='tgl' value="<?= date('Y-m-d') ?>" readonly>
    </div>
</div>

                                    <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                             <select  type="select" class="form-control" name="st" required>
               <option>Pilih</option>
               <option value="Aktif">Aktif</option>
               <option value="Arsip">Arsip</option>
             </select>
                                        </div>
                                    </div>


                                    
                                    <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Deskripsi Kamar" class="form-control" name='deskripsi' required>
                                        </div>
                                    </div>


<!--                                                                        <div class="form-group row">
                                       <label for="inputFile" class="col-sm-2 col-form-label">Foto Kamar</label>
                                       <div class="col-sm-10">
                                           <input type="file" class="form-control" name="foto_kamar" id="inputFile" required>
                                       </div>
                                   </div> -->




                                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>