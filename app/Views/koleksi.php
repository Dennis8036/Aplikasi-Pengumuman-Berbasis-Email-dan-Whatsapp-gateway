<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Pribadi</title>
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
                                    <th>Nama Koleksi</th>
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
                                foreach($koleksi as $item) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->id_kategori ?></td>
                                    <td><?= $item->judul ?></td>
                                    <td><?= $item->penulis ?></td>
                                    <td><?= $item->penerbit ?></td>
                                    <td><?= $item->tahunterbit ?></td>
                                    <td>
                                        
                                           
                                        <a href="<?= base_url('Home/hapus_koleksi/'.$item->id_koleksi) ?>">
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

    <!-- Edit Koleksi Modal -->
    <div class="modal fade" id="editKoleksiModal" tabindex="-1" aria-labelledby="editKoleksiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKoleksiModalLabel">Edit Koleksi</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editKoleksiForm" action="<?= base_url('Home/aksi_edit_koleksi') ?>" method="POST">
                        <input type="hidden" id="id_koleksi" name="id_koleksi">
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
            $('#editKoleksiModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id_koleksi = button.data('id');
                var judul = button.data('judul');
                var penulis = button.data('penulis');
                var penerbit = button.data('penerbit');
                var tahunterbit = button.data('tahunterbit');

                var modal = $(this);
                modal.find('#id_koleksi').val(id_koleksi);
                modal.find('#edit_judul').val(judul);
                modal.find('#edit_penulis').val(penulis);
                modal.find('#edit_penerbit').val(penerbit);
                modal.find('#edit_tahunterbit').val(tahunterbit);
            });
        });
    </script>
</body>
</html>
