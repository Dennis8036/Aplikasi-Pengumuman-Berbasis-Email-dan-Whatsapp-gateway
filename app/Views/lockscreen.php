<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url('vendors/ti-icons/css/themify-icons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('vendors/base/vendor.bundle.base.css') ?>">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?= base_url('images/') ?>" />
  <style>
      .profile-img {
          width: 130px;
          height: 130px;
          border-radius: 50%;
          object-fit: cover;
      }
      /* Custom Modal Success */
      .modal-success .modal-content {
          background-color: #28a745; /* Hijau */
          color: white;
      }
      /* Custom Modal Error */
      .modal-error .modal-content {
          background-color: #dc3545; /* Merah */
          color: white;
      }
  </style>
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth lock-full-bg">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-transparent text-left p-5 text-center">
              <a>
                <img src="<?= ($dennis->foto_profile) ? base_url('images/img/' . $dennis->foto_profile) : base_url('images/img/fotouser.jfif') ?>" 
                     class="profile-img" 
                     alt="Foto Profile">
              </a>
              <form class="pt-5" action="<?= base_url('Home/validatePassword') ?>" method="post">
                <div class="form-group">
                  <label for="password">Password to unlock</label>
                  <input type="password" class="form-control text-center" id="password" name="password" placeholder="Password">
                </div>
                <div class="mt-5">
                  <button type="submit" class="btn btn-block btn-success btn-lg font-weight-medium">Unlock</button>
                </div>
                <div class="mt-3 text-center">
                  <a href="<?= base_url('Home/login')?>" class="auth-link text-white">Sign in using different account</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
  <!-- Modal Success -->
  <div class="modal fade modal-success" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Success</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Password correct! Redirecting to dashboard...
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Error -->
  <div class="modal fade modal-error" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">Error</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Incorrect password. Please try again.
        </div>
      </div>
    </div>
  </div>

  <!-- plugins:js -->
  <script src="<?= base_url('vendors/base/vendor.bundle.base.js') ?>"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?= base_url('js/off-canvas.js') ?>"></script>
  <script src="<?= base_url('js/hoverable-collapse.js') ?>"></script>
  <script src="<?= base_url('js/template.js') ?>"></script>
  <script src="<?= base_url('js/todolist.js') ?>"></script>
  <!-- endinject -->

  <!-- Modal Trigger based on session -->
  <script>
    <?php if(session()->getFlashdata('success')): ?>
      $('#successModal').modal('show');
      setTimeout(function() {
        window.location.href = "<?= base_url('Home/dashboard') ?>";
      }, 2000);
    <?php elseif(session()->getFlashdata('error')): ?>
      $('#errorModal').modal('show');
    <?php endif; ?>
  </script>
</body>
</html>
