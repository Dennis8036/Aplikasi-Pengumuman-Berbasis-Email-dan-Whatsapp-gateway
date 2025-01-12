    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acara</title>
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

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Acara</th>
                                    <th>Tanggal Post</th>
                                    <th>Tanggal Acara</th>
                                    <th>Waktu Dibuat</th>
                                    <th>Waktu Diperbarui</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($acara as $event){
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $event->nama_acara ?></td>
                                    <td><?= $event->tanggalharini ?></td>
                                    <td><?= $event->tanggal_acara ?></td>
                                    <td><?= $event->create_at ?></td>
                                    <td><?= $event->update_at ?></td>
                                     <td><?= $event->status ?></td>
                                    <td>
                                        <a href="<?= base_url('Home/restore_data_edit_pencatatan/'.$event->id_acara) ?>">
                                            <button class="btn btn-primary ti-back-left" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Restore">
                                            </button>
                                        </a>
                                        <a href="<?= base_url('Home/hapus_acara/'.$event->id_acara) ?>">
                                            <button class="btn btn-danger ti-trash" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    title="Hapus">
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

    <!-- Edit Acara Modal -->
    <div class="modal fade" id="editAcaraModal" tabindex="-1" aria-labelledby="editAcaraModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAcaraModalLabel">Edit Acara</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAcaraForm" action="<?= base_url('Home/aksi_edit_acara') ?>" method="POST">
                        <input type="hidden" id="id_acara" name="id_acara">
                        <div class="mb-3">
                            <label for="edit_nama_acara" class="form-label">Nama Acara</label>
                            <input type="text" class="form-control" id="edit_nama_acara" name="nama_acara" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_acara" class="form-label">Tanggal Acara</label>
                            <input type="date" class="form-control" id="edit_tanggal_acara" name="tanggal_acara" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
               <option value="Aktif">Aktif</option>  
               <option value="Selesai">Selesai</option>
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
            $('#editAcaraModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_acara = button.data('id');
                var nama = button.data('nama');
                var tanggal = button.data('tanggal');
                var status = button.data('status');

                var modal = $(this);
                modal.find('#id_acara').val(id_acara);
                modal.find('#edit_nama_acara').val(nama);
                modal.find('#edit_tanggal_acara').val(tanggal);
                modal.find('#edit_status').val(status);
            });
        });
    </script>
</body>
</html>
