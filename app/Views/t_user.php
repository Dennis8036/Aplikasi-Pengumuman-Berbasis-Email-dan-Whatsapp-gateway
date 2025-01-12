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
            min-width: 900px; /* Ensure table is wide enough */
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

                           
                                <table class="table">
                                <!-- General Form Elements -->
                                <form action="<?= base_url('Home/aksi_t_user')?>" method="POST">

                                    <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Username" name='username'>
                                        </div>
                                     </div>

                                      <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Password" name='password'>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Email" name='email'>
                                        </div>
                                    </div>
                                    
                                                                        <div class="form-group row">
                                        <label for="inputText" class="col-sm-2 col-form-label">Nomor Whatsapp</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" placeholder="Nomor Whatsapp" name='wa'>
                                        </div>
                                    </div>

<div class="form-group row">
    <label for="inputText" class="col-sm-2 col-form-label">Level</label>
    <div class="col-sm-10">
        <select id="levelSelect" class="form-control" name="level" required>
            <option value="">Pilih</option>
            <option value="1">Kepala Sekolah</option>
            <option value="2">Wakil Kepala Sekolah</option>
            <option value="3">Guru</option>
            <option value="4">Orang Tua</option>
            <option value="5">Siswa</option>
        </select>
    </div>
</div>

<div class="form-group row" id="kelasForm" style="display: none;">
    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
    <div class="col-sm-10">
        <select id="kelasSelect" class="form-control" name="kelas">
            <option value="">Pilih</option>
            <?php foreach($kelas as $dennis): ?>
                <option value="<?=$dennis->id_kelas?>">
                    <?=$dennis->nama_kelas?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

                                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </table>
                        </div>
                    </div>
                                <!-- End General Form Elements -->
<script>
    // Ambil elemen
    const levelSelect = document.getElementById('levelSelect');
    const kelasForm = document.getElementById('kelasForm');
    const kelasSelect = document.getElementById('kelasSelect');

    // Tambahkan event listener untuk level
    levelSelect.addEventListener('change', function () {
        if (this.value === '5') { // Jika level adalah Siswa
            kelasForm.style.display = 'flex'; // Tampilkan form Kelas
            kelasSelect.setAttribute('required', 'required'); // Tambahkan atribut required
            kelasSelect.value = ''; // Biarkan pengguna memilih kelas
        } else {
            kelasForm.style.display = 'none'; // Sembunyikan form Kelas
            kelasSelect.removeAttribute('required'); // Hapus atribut required
            kelasSelect.value = 'N/A'; // Otomatis set nilai ke "N/A"
        }
    });
</script>