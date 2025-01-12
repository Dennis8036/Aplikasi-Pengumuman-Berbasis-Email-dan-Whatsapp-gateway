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

<table class="table table-bordered">
    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No Kamar</th>
                                            <th>Nama Penghuni</th>
                                            <!-- <th>No KTP</th> -->
                                            <!-- <th>Asal</th> -->
                                            <th>No Hp</th>
                                            <th>Masa Huni</th>

                                            <th>Total Bayar</th>
                                            <!-- <th>Total Sudah Bayar</th> -->
                                            <th>Piutang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($penghuni as $p) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->no_kamar ?></td>
                                            <td><?= $p->nama ?></td>
                                           <!--  <td><?= $p->no_ktp ?></td> -->
                                            <!-- <td><?= $p->asal ?></td> -->
                                            <td><?= $p->no_hp ?></td>
 <td><?= $p->tgl_msk . ' - ' . $p->tgl_klr ?></td> <!-- Concatenated Date -->
                                           <td>Rp <?= number_format($p->total_bayar, 0, ',', '.') ?></td>


                                            <!-- <td><?= $p->total_sudah_bayar ?></td> -->
                                            <td><?= $p->piutang ?></td>
                                            <td>
                                                <?php if(session()->get('id_level') == 1) { ?>
                                                    <button class="btn btn-primary ti-pencil" 
                                                        data-toggle="modal" 
                                                        data-target="#editModal" 
                                                        data-id="<?= $p->id_penghuni ?>"
                                                        data-no_kamar="<?= $p->no_kamar ?>"
                                                        data-nama="<?= $p->nama ?>"
                                                        data-no_ktp="<?= $p->no_ktp ?>"
                                                        data-asal="<?= $p->asal ?>"
                                                        data-no_hp="<?= $p->no_hp ?>"
                                                        data-tgl_msk="<?= $p->tgl_msk ?>"
                                                        data-tgl_klr="<?= $p->tgl_klr ?>"
                                                        data-total_bayar="<?= $p->total_bayar ?>"
                                                        data-total_sudah_bayar="<?= $p->total_sudah_bayar ?>"
                                                        data-piutang="<?= $p->piutang ?>"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Edit"
                                                        ></button>

                                                    <a href="<?= base_url('Home/hapus_penghuni/'.$p->id_penghuni)?>">
                                                        <button class="btn btn-danger ti-trash"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Hapus"
                                                        ></button>
                                                    </a>
                                                <?php } ?>
                                                    <a href="<?= base_url('Home/t_pembayaran/'.$p->id_penghuni )?>">
                                                        <button class="btn btn-warning ti-money"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Bayar"
                                                        ></button>
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
        </div>
        <!-- #/ container -->
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Penghuni</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="<?= base_url('Home/aksi_e_penghuni') ?>" method="POST">
                        <input type="hidden" value="" id="id" name="id_penghuni"> <!-- ID ini akan diisi oleh JavaScript -->
                        <div class="mb-3">
                            <label for="edit_no_kamar" class="form-label">No Kamar</label>
                            <input type="text" class="form-control" value="" id="edit_no_kamar" name="no_kamar" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Penghuni</label>
                            <input type="text" class="form-control" value="" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_ktp" class="form-label">No KTP</label>
                            <input type="text" class="form-control" value="" id="edit_no_ktp" name="no_ktp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_asal" class="form-label">Asal</label>
                            <input type="text" class="form-control" value="" id="edit_asal" name="asal" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_hp" class="form-label">No Hp</label>
                            <input type="text" class="form-control" value="" id="edit_no_hp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tgl_msk" class="form-label">Masa Huni Awal</label>
                            <input type="date" class="form-control" value="" id="edit_tgl_msk" name="tgl_msk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tgl_klr" class="form-label">Masa Huni Akhir</label>
                            <input type="date" class="form-control" value="" id="edit_tgl_klr" name="tgl_klr" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_total_bayar" class="form-label">Total Bayar</label>
                            <input type="text" class="form-control" value="" id="edit_total_bayar" name="total_bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_total_sudah_bayar" class="form-label">Total Sudah Bayar</label>
                            <input type="text" class="form-control" value="" id="edit_total_sudah_bayar" name="total_sudah_bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_piutang" class="form-label">Piutang</label>
                            <input type="text" class="form-control" value="" id="edit_piutang" name="piutang" required>
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
                var id = button.data('id'); // Extract info from data-* attributes
                var no_kamar = button.data('no_kamar');
                var nama = button.data('nama');
                var no_ktp = button.data('no_ktp');
                var asal = button.data('asal');
                var no_hp = button.data('no_hp');
                var tgl_msk = button.data('tgl_msk');
                var tgl_klr = button.data('tgl_klr');
                var total_bayar = button.data('total_bayar');
                var total_sudah_bayar = button.data('total_sudah_bayar');
                var piutang = button.data('piutang');

                // Update the modal's content
                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#edit_no_kamar').val(no_kamar);
                modal.find('#edit_nama').val(nama);
                modal.find('#edit_no_ktp').val(no_ktp);
                modal.find('#edit_asal').val(asal);
                modal.find('#edit_no_hp').val(no_hp);
                modal.find('#edit_tgl_msk').val(tgl_msk);
                modal.find('#edit_tgl_klr').val(tgl_klr);
                modal.find('#edit_total_bayar').val(total_bayar);
                modal.find('#edit_total_sudah_bayar').val(total_sudah_bayar);
                modal.find('#edit_piutang').val(piutang);
            });
        });
    </script>
</body>
</html>
