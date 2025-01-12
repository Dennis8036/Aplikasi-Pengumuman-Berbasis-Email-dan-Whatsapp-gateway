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

                            <div class="table-responsive">
<!--                                                                 <a href="<?= base_url('Home/t_pembayaran') ?>">
                                    <button class="btn btn-success">Tambah</button>
                                </a> -->
<table class="table table-bordered">
    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No Kamar</th>
                                            <th>Nama Penghuni</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Bayar</th>
                                            <th>Nominal Bayar</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($pembayaran as $bayar) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $bayar->no_kamar ?></td>
                                            <td><?= $bayar->nama ?></td>
                                            <td><?= $bayar->tanggal_transaksi ?></td>    
                                            <td>Rp <?= number_format($bayar->total_bayar, 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($bayar->jumlah_bayar, 0, ',', '.') ?></td>
                                            <td><?= $bayar->keterangan ?></td>
                                            <td>
                                                <?php if(session()->get('id_level') == 1) { ?>
                                                    <button class="btn btn-primary ti-pencil" 
                                                        data-toggle="modal" 
                                                        data-target="#editModal" 
                                                        data-id="<?= $bayar->id_pembayaran ?>"
                                                        data-no_kamar="<?= $bayar->no_kamar ?>"
                                                        data-nama="<?= $bayar->nama ?>"
                                                        data-tanggal_transaksi="<?= $bayar->tanggal_transaksi ?>"           
                                                        data-total_bayar="<?= $bayar->total_bayar ?>"
                                                        data-jumlah_bayar="<?= $bayar->jumlah_bayar ?>"
                                                        data-keterangan="<?= $bayar->keterangan ?>"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit"
                                                        ></button>
                                                    <a href="<?= base_url('Home/hapus_pembayaran/'.$bayar->id_pembayaran)?>">
    <button class="btn btn-danger ti-trash" 
            data-toggle="tooltip" 
            data-placement="top" 
            title="Hapus"
            ></button>
                                                    </a>
                                                <?php } ?>
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
        </div>
        <!-- #/ container -->
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pembayaran</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('Home/aksi_e_pembayaran') ?>" method="POST">
                        <input type="hidden" value="" id="id_pembayaran" name="id_pembayaran"> <!-- ID ini akan diisi oleh JavaScript -->
                        <div class="mb-3">
                            <label for="edit_no_kamar" class="form-label">No Kamar</label>
                            <input type="text" class="form-control" value="" id="edit_no_kamar" name="no_kamar" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Penghuni</label>
                            <input type="text" class="form-control" value="" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                            <input type="date" class="form-control" value="" id="edit_tanggal_transaksi" name="tanggal_transaksi" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_total_bayar" class="form-label">Total Bayar</label>
                            <input type="text" class="form-control" value="" id="edit_total_bayar" name="total_bayar" required>
                        </div>
                                                <div class="mb-3">
                            <label for="edit_jumlah_bayar" class="form-label">Jumlah Bayar</label>
                            <input type="text" class="form-control" value="" id="edit_jumlah_bayar" name="jumlah_bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="edit_keterangan" name="keterangan" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include your JavaScript files here -->
    <script src="path/to/your/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/your/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {

            $('[data-toggle="tooltip"]').tooltip();

            $('#editModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id_pembayaran = button.data('id');
                var no_kamar = button.data('no_kamar');
                var nama = button.data('nama');
                var tanggal_transaksi = button.data('tanggal_transaksi');
                
                var total_bayar = button.data('total_bayar');
                var jumlah_bayar = button.data('jumlah_bayar');
                var keterangan = button.data('keterangan');

                // Update the modal's content
                var modal = $(this);
                modal.find('#id_pembayaran').val(id_pembayaran);
                modal.find('#edit_no_kamar').val(no_kamar);
                modal.find('#edit_nama').val(nama);
                modal.find('#edit_tanggal_transaksi').val(tanggal_transaksi);
                
                modal.find('#edit_total_bayar').val(total_bayar);
                modal.find('#edit_jumlah_bayar').val(jumlah_bayar);
                modal.find('#edit_keterangan').val(keterangan);
            });
        });
    </script>
</body>
</html>
