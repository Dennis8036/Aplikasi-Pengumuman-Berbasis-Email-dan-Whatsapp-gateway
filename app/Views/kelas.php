<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas</title>
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
            min-width: 800px;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if(session()->get('id_level') == 1) { ?>
                        <a href="<?= base_url('home/t_kelas') ?>">
                            <button class="btn btn-success">Tambah Kelas</button>
                        </a>
                        <?php } ?>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    
<?php if(session()->get('id_level') == 1) { ?>
                                    <th>Aksi</th>
                                     <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($kelas as $k){
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $k->nama_kelas ?></td>
                                    
<?php if(session()->get('id_level') == 1) { ?>
                                    <td>
                                        <button class="btn btn-primary ti-pencil" 
                                                data-toggle="modal" 
                                                data-target="#editKelasModal" 
                                                data-id="<?= $k->id_kelas ?>"
                                                data-nama="<?= $k->nama_kelas ?>"
                                               
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Edit">
                                        </button>
                                        <a href="<?= base_url('Home/hapus_kelas/'.$k->id_kelas) ?>">
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

    <!-- Edit Kelas Modal -->
    <div class="modal fade" id="editKelasModal" tabindex="-1" aria-labelledby="editKelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKelasModalLabel">Edit Kelas</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editKelasForm" action="<?= base_url('Home/aksi_edit_kelas') ?>" method="POST">
                        <input type="hidden" id="id_kelas" name="id_kelas">
                        <div class="mb-3">
                            <label for="edit_nama_kelas" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="edit_nama_kelas" name="nama_kelas" required>
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
            $('#editKelasModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_kelas = button.data('id');
                var nama = button.data('nama');
                

                var modal = $(this);
                modal.find('#id_kelas').val(id_kelas);
                modal.find('#edit_nama_kelas').val(nama);
                
            });
        });
    </script>
</body>
</html>
