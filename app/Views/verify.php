<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Verifikasi Email</title>
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <h4>Verifikasi Akun Anda</h4>
              <p>Masukkan kode verifikasi yang telah dikirimkan ke email Anda:</p>

              <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                  <?= session()->getFlashdata('error') ?>
                </div>
              <?php endif; ?>

              <form action="<?= base_url('Home/verify') ?>" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control" name="kode_verifikasi" placeholder="Kode Verifikasi" required>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Verifikasi</button>
                </div>
              </form>
              <div class="text-center mt-4 font-weight-light">
                <a href="<?= base_url('Home/register') ?>" class="text-primary">Kembali ke Registrasi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
