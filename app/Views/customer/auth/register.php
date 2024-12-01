<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('admin/') ?>assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?= base_url('admin/') ?>assets/css/styles.min.css" />
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- sweet alert logic -->
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
            })
        </script>
    <?php endif ?>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="<?= base_url('customer/') ?>img/logo.png" width="180" alt="">
                                </a>
                                <p class="text-center">Silahkan Login Untuk Melanjutkan!</p>
                                <form method="POST" action="<?= base_url('signup') ?>">
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="full_name" id="exampleInputtext1" aria-describedby="textHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Alamat Email</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">No. HP</label>
                                        <input type="text" class="form-control" name="phone" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Sudah Punya Akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="<?= base_url('customer/login') ?>">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('admin/') ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url('admin/') ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>