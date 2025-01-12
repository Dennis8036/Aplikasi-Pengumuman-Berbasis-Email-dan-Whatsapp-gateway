<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ulasan Buku</title>
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
            min-width: 1000px;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <a href="<?= base_url('Home/t_ulasan') ?>">
                            <button class="btn btn-success">Tambah Ulasan</button>
                        </a>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Judul Buku</th>
                                    <th>Ulasan</th>
                                    <th>Rating</th>
<?php if(session()->get('id_level') == 1 || session()->get('id_level') == 2) { ?>
                                    <th>Aksi</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($ulasan as $ul) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $ul->username ?></td>
                                    <td><?= $ul->judul ?></td>
                                    <td><?= $ul->ulasan ?></td>
                                    <td><?= $ul->rating ?></td>
                                    <?php if(session()->get('id_level') == 1 || session()->get('id_level') == 2) { ?>
                                    <td>
                                        
                                        <button class="btn btn-primary ti-pencil" 
                                                data-toggle="modal" 
                                                data-target="#editUlasanModal" 
                                                data-id="<?= $ul->id_ulasan ?>"
                                                data-id_buku="<?= $ul->id_buku ?>"
                                                data-ulasan="<?= $ul->ulasan ?>"
                                                data-rating="<?= $ul->rating ?>"
                                                title="Edit">
                                        </button>
                                        <a href="<?= base_url('Home/hapus_ulasan/'.$ul->id_ulasan) ?>">
                                            <button class="btn btn-danger ti-trash" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Hapus">
                                            </button>
                                        </a>
                                        
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Ulasan Modal -->
    <div class="modal fade" id="editUlasanModal" tabindex="-1" aria-labelledby="editUlasanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUlasanModalLabel">Edit Ulasan</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUlasanForm" action="<?= base_url('Home/aksi_e_ulasan') ?>" method="POST">
                        <input type="hidden" id="id_ulasan" name="id_ulasan">


                        <div class="mb-3">
                            <label for="edit_judul" class="form-label">Judul Buku</label>

                            <select type="text" class="form-control" id="edit_judul" name="judul">
                               
                                  <?php foreach($buku as $dennis): ?>
                                    <option value="<?=$dennis->id_buku?>">
                                      <?=$dennis->judul?>
                                    </option>
                                  <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="edit_ulasan" class="form-label">Ulasan</label>
                            <textarea class="form-control" id="edit_ulasan" name="ulasan" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_rating" class="form-label">Rating</label>
                            <select class="form-control" id="edit_rating" name="rating" required>
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="path/to/your/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/your/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#editUlasanModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_ulasan = button.data('id');
                var id_buku = button.data('id_buku');
                var ulasan = button.data('ulasan');
                var rating = button.data('rating');

                var modal = $(this);
                modal.find('#id_ulasan').val(id_ulasan);
                modal.find('#edit_judul').val(id_buku);
                modal.find('#edit_ulasan').val(ulasan);
                modal.find('#edit_rating').val(rating);
            });
        });
    </script>
</body>
</html>
