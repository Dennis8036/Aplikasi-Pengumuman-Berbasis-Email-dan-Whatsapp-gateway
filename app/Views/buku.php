<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku</title>
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
            min-width: 1300px;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <?php if(session()->get('id_level') == 1 || session()->get('id_level') == 2) { ?>
                        <a href="<?= base_url('Home/t_buku') ?>">
                            <button class="btn btn-success">Tambah Buku</button>
                        </a>



                        <?php } ?>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($buku as $surat){
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $surat->nama_kategori ?></td>
                                    <td><?= $surat->judul ?></td>
                                    <td><?= $surat->penulis ?></td>
                                    <td><?= $surat->penerbit ?></td>
                                    <td><?= $surat->tahunterbit ?></td>
                                    
                                    <td>
                                        <?php if(session()->get('id_level') == 1 || session()->get('id_level') == 2) { ?>
                                        <button class="btn btn-primary ti-pencil" 
                                                data-toggle="modal" 
                                                data-target="#editSuratModal" 
                                                data-id="<?= $surat->id_buku ?>"
                                                data-id_kategori="<?= $surat->id_kategori ?>"
                                                data-judul="<?= $surat->judul ?>"
                                                data-penulis="<?= $surat->penulis ?>"
                                                data-penerbit="<?= $surat->penerbit ?>"
                                                data-tahunterbit="<?= $surat->tahunterbit ?>"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Edit">
                                        </button>
                                        <a href="<?= base_url('Home/hapus_buku/'.$surat->id_buku) ?>">
                                            <button class="btn btn-danger ti-trash" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Hapus">
                                            </button>
                                        </a>
<?php } ?>
                                        <a href="<?= base_url('Home/t_koleksi/'.$surat->id_kategori) ?>">
                                            <button class="btn btn-success ti-heart" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Favorite">
                                            </button>
                                        </a>
                                        

                                    </td>
                                    
                                    
                                </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Surat Modal -->
    <div class="modal fade" id="editSuratModal" tabindex="-1" aria-labelledby="editSuratModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuratModalLabel">Edit Buku</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editSuratForm" action="<?= base_url('Home/aksi_e_buku') ?>" method="POST">
                        <input type="hidden" id="id_buku" name="id_buku">

 
                        <div class="mb-3">
                            <label for="edit_kategori" class="form-label">Nama Kategori</label>

                            <select type="text" class="form-control" id="edit_kategori" name="kategori">
                               
                                  <?php foreach($kategori as $erwin): ?>
                                    <option value="<?=$erwin->id_kategori?>">
                                      <?=$erwin->nama_kategori?>
                                    </option>
                                  <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="edit_penulis" name="penulis" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="edit_penerbit" name="penerbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tahunterbit" class="form-label">Tahun Terbit</label>
                            <input type="text" class="form-control" id="edit_tahunterbit" name="tahunterbit" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/your/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('#editSuratModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_buku = button.data('id');
                var id_kategori = button.data('id_kategori');
                var judul = button.data('judul');
                var penulis = button.data('penulis');
                var penerbit = button.data('penerbit');
                var tahunterbit = button.data('tahunterbit');

                var modal = $(this);
                modal.find('#id_buku').val(id_buku);
                modal.find('#edit_kategori').val(id_kategori);
                modal.find('#edit_judul').val(judul);
                modal.find('#edit_penulis').val(penulis);
                modal.find('#edit_penerbit').val(penerbit);
                modal.find('#edit_tahunterbit').val(tahunterbit);
               
            });
        });
    </script>
</body>
</html>
