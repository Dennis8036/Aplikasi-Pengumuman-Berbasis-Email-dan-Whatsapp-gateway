<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen</title>
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
                        <a href="<?= base_url('Home/t_dokumen') ?>">
                            <button class="btn btn-success">Tambah Dokumen</button>
                        </a>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Dokumen</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($dokumen as $doc){
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $doc->judul_dokumen ?></td>
                                    <td><?= $doc->kategori_dokumen ?></td>
                                    <td><?= $doc->tanggal_dokumen ?></td>
                                    <td><?= $doc->deskripsi ?></td>
                                    <td><?= $doc->status_dokumen ?></td>
                                    <td>
                                        <button class="btn btn-primary ti-pencil" 
                                                data-toggle="modal" 
                                                data-target="#editDokumenModal" 
                                                data-id="<?= $doc->id_dokumen ?>"
                                                data-judul="<?= $doc->judul_dokumen ?>"
                                                data-kategori="<?= $doc->kategori_dokumen ?>"
                                                data-tanggal="<?= $doc->tanggal_dokumen ?>"
                                                data-deskripsi="<?= $doc->deskripsi ?>"
                                                data-status="<?= $doc->status_dokumen ?>"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Edit">
                                        </button>
                                        <a href="<?= base_url('Home/hapus_dokumen/'.$doc->id_dokumen) ?>">
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

    <!-- Edit Dokumen Modal -->
    <div class="modal fade" id="editDokumenModal" tabindex="-1" aria-labelledby="editDokumenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDokumenModalLabel">Edit Dokumen</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDokumenForm" action="<?= base_url('Home/aksi_edit_dokumen') ?>" method="POST">
                        <input type="hidden" id="id_dokumen" name="id_dokumen">
                        <div class="mb-3">
                            <label for="edit_judul_dokumen" class="form-label">Judul Dokumen</label>
                            <input type="text" class="form-control" id="edit_judul_dokumen" name="judul_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kategori_dokumen" class="form-label">Kategori Dokumen</label>
                            <input type="text" class="form-control" id="edit_kategori_dokumen" name="kategori_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_dokumen" class="form-label">Tanggal Dokumen</label>
                            <input type="date" class="form-control" id="edit_tanggal_dokumen" name="tanggal_dokumen" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status_dokumen" class="form-label">Status Dokumen</label>
                            <select class="form-control" id="edit_status_dokumen" name="status_dokumen" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Arsip">Arsip</option>
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
            $('#editDokumenModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_dokumen = button.data('id');
                var judul = button.data('judul');
                var kategori = button.data('kategori');
                var tanggal = button.data('tanggal');
                var deskripsi = button.data('deskripsi');
                var status = button.data('status');

                var modal = $(this);
                modal.find('#id_dokumen').val(id_dokumen);
                modal.find('#edit_judul_dokumen').val(judul);
                modal.find('#edit_kategori_dokumen').val(kategori);
                modal.find('#edit_tanggal_dokumen').val(tanggal);
                modal.find('#edit_deskripsi').val(deskripsi);
                modal.find('#edit_status_dokumen').val(status);
            });
        });
    </script>
</body>
</html>
