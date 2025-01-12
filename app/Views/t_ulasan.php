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
                                <form action="<?= base_url('Home/aksi_t_ulasan')?>" method="POST">

<!-- Hidden field untuk id_user -->
<input type="hidden" name="id_user" value="<?= session()->get('id_user'); ?>">




<div class="form-group row">
    <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
    <div class="col-sm-10">
        <select class="form-control" name="judul_buku" required>
            <option value="">Pilih</option>
            <?php foreach($buku as $dennis): ?>
                <option value="<?=$dennis->id_buku?>">
                    <?=$dennis->judul?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>


<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Ulasan</label>
    <div class="col-sm-10">
        <textarea class="form-control" placeholder="Tulis ulasan Anda" name="ulasan" rows="5" required></textarea>
    </div>
</div>

<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Rating</label>
    <div class="col-sm-10">
        <select class="form-control" name="rating" required>
            <option value="">Pilih</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>
</div>


                                    
                                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>
                                <!-- End General Form Elements -->