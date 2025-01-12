<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
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
                        <a href="<?= base_url('Home/t_peminjaman') ?>">
                            <button class="btn btn-success">Tambah Peminjaman</button>
                        </a>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Status Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($peminjaman as $pinjam):
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pinjam->username ?></td>
                                    <td><?= $pinjam->judul ?></td>
                                    <td><?= $pinjam->tanggalpeminjaman ?></td>
                                    <td><?= $pinjam->tanggalpengembalian ?></td>
                                    <td><?= $pinjam->statuspeminjaman ?></td>
                                    <td>
<?php if (($pinjam->statuspeminjaman == 'Dipinjam' && $pinjam->id_user == session()->get('id_user')) || session()->get('id_level') == 1 || session()->get('id_level') == 2): ?>
    <button class="btn btn-primary ti-pencil" 
            data-toggle="modal" 
            data-target="#editPeminjamanModal" 
            data-id="<?= $pinjam->id_peminjaman ?>"
            data-id_buku="<?= $pinjam->id_buku ?>"
            data-tanggalpeminjaman="<?= $pinjam->tanggalpeminjaman ?>"
            data-tanggalpengembalian="<?= $pinjam->tanggalpengembalian ?>"
            data-statuspeminjaman="<?= $pinjam->statuspeminjaman ?>"
            data-toggle="tooltip"
            data-placement="top"
            title="Edit">
    </button>
    <a href="<?= base_url('Home/hapus_peminjaman/'.$pinjam->id_peminjaman) ?>">
        <button class="btn btn-danger ti-trash" 
                data-toggle="tooltip" 
                data-placement="top" 
                title="Hapus">
        </button>
    </a>
<?php endif; ?>

</td>

                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Peminjaman Modal -->
    <div class="modal fade" id="editPeminjamanModal" tabindex="-1" aria-labelledby="editPeminjamanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPeminjamanModalLabel">Edit Peminjaman</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPeminjamanForm" action="<?= base_url('Home/aksi_e_peminjaman') ?>" method="POST">
                        <input type="hidden" id="id_peminjaman" name="id_peminjaman">

                        <div class="mb-3">
                            <label for="edit_buku" class="form-label">Judul Buku</label>
                            <select class="form-control" id="edit_buku" name="id_buku">
                                <?php foreach($buku as $book): ?>
                                    <option value="<?= $book->id_buku ?>"><?= $book->judul ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggalpeminjaman" class="form-label">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="edit_tanggalpeminjaman" name="tanggalpeminjaman" readonly style="background-color: white;">
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggalpengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="edit_tanggalpengembalian" name="tanggalpengembalian" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_statuspeminjaman" class="form-label">Status Peminjaman</label>
                            <select class="form-control" id="edit_statuspeminjaman" name="statuspeminjaman" required>
                                <option value="Dipinjam">Dipinjam</option>
                                <option value="Dikembalikan">Dikembalikan</option>
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
            $('#editPeminjamanModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_peminjaman = button.data('id');
                
                var id_buku = button.data('id_buku');
                var tanggalpeminjaman = button.data('tanggalpeminjaman');
                var tanggalpengembalian = button.data('tanggalpengembalian');
                var statuspeminjaman = button.data('statuspeminjaman');

                var modal = $(this);
                modal.find('#id_peminjaman').val(id_peminjaman);
                
                modal.find('#edit_buku').val(id_buku);
                modal.find('#edit_tanggalpeminjaman').val(tanggalpeminjaman);
                modal.find('#edit_tanggalpengembalian').val(tanggalpengembalian);
                modal.find('#edit_statuspeminjaman').val(statuspeminjaman);
            });
        });
    </script>
</body>
</html>
