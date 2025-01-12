<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumuman</title>
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
<div class="d-flex justify-content-between mb-3">
    <a href="<?= base_url('Home/t_pengumuman') ?>">
        <button class="btn btn-success">Tambah Pengumuman</button>
    </a>
    <div>
        <button class="btn btn-info dropdown-toggle" id="emailDropdown" data-toggle="dropdown" aria-expanded="false">
            Kirim Email
        </button>
        <div class="dropdown-menu" aria-labelledby="emailDropdown">
            <a class="dropdown-item" href="#" onclick="sendEmail('all')">Semua Pengguna</a>
            <a class="dropdown-item" href="#" onclick="sendEmail('Orang Tua')">Orang Tua</a>
            <a class="dropdown-item" href="#" onclick="sendEmail('Siswa')">Siswa</a>
        </div>
        <button class="btn btn-success dropdown-toggle" id="waDropdown" data-toggle="dropdown" aria-expanded="false">
            Kirim WhatsApp
        </button>
        <div class="dropdown-menu" aria-labelledby="waDropdown">
            <a class="dropdown-item" href="#" onclick="sendWhatsApp('all')">Semua Pengguna</a>
            <a class="dropdown-item" href="#" onclick="sendWhatsApp('Orang Tua')">Orang Tua</a>
            <a class="dropdown-item" href="#" onclick="sendWhatsApp('Siswa')">Siswa</a>
        </div>
    </div>
</div>

                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal Pengumuman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($pengumuman as $item){
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->username ?></td>
                                    <td><?= $item->judul ?></td>
                                    <td><?= substr($item->isi, 0, 50) ?>...</td>
                                    <td><?= $item->tujuan ?></td>
                                    <td><?= $item->created_at ?></td>
                                    <td>
                                        <button class="btn btn-primary ti-pencil" 
                                                data-toggle="modal" 
                                                data-target="#editPengumumanModal" 
                                                data-id="<?= $item->id_pengumuman ?>"
                                                data-judul="<?= $item->judul ?>"
                                                data-isi="<?= $item->isi ?>"
                                                data-tujuan="<?= $item->tujuan ?>"
                                                title="Edit">
                                        </button>
                                        <a href="<?= base_url('Home/hapus_pengumuman/'.$item->id_pengumuman) ?>">
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

    <!-- Edit Pengumuman Modal -->
    <div class="modal fade" id="editPengumumanModal" tabindex="-1" aria-labelledby="editPengumumanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengumumanModalLabel">Edit Pengumuman</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPengumumanForm" action="<?= base_url('Home/aksi_e_pengumuman') ?>" method="POST">
                        <input type="hidden" value="" id="id_pengumuman" name="id_pengumuman">
                        <div class="mb-3">
                            <label for="edit_judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="edit_judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_isi" class="form-label">Isi</label>
                            <textarea class="form-control" id="edit_isi" name="isi" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tujuan" class="form-label">Tujuan</label>
                            <select class="form-control" id="edit_tujuan" name="tujuan" required>
                                <option value="Orang Tua Dan Siswa">Orang Tua Dan Siswa</option>
                                <option value="Orang Tua">Orang Tua</option>
                                <option value="Siswa">Siswa</option>
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
    $(document).ready(function () {
        // Tooltip initialization
        $('[data-toggle="tooltip"]').tooltip();

        // Modal edit handler
        $('#editPengumumanModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id_pengumuman = button.data('id');
            var judul = button.data('judul');
            var isi = button.data('isi');
            var tujuan = button.data('tujuan');

            var modal = $(this);
            modal.find('#id_pengumuman').val(id_pengumuman);
            modal.find('#edit_judul').val(judul);
            modal.find('#edit_isi').val(isi);
            modal.find('#edit_tujuan').val(tujuan);
        });

        // Function to send email
        window.sendEmail = function (target) {
    const url = "<?= base_url('Home/kirim_email') ?>";
    if (confirm(`Kirim email ke ${target}?`)) {
        $.post(url, { tujuan: target }, function (response) {
            alert(response.message || "Email berhasil dikirim!");
        }).fail(function () {
            alert("Gagal mengirim email.");
        });
    }
};

window.sendWhatsApp = function (target) {
    const url = "<?= base_url('Home/kirim_wa') ?>";
    if (confirm(`Kirim WhatsApp ke ${target}?`)) {
        $.post(url, { tujuan: target }, function (response) {
            alert(response.message || "Pesan WhatsApp berhasil dikirim!");
        }).fail(function () {
            alert("Gagal mengirim pesan WhatsApp.");
        });
    }
};

    });
</script>

</body>
</html>
