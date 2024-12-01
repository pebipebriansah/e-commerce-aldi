<?= $this->extend('customer/template'); ?>

<!-- render heder -->
<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- sweet alert -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= session()->getFlashdata('error') ?>',
        })
    </script>
<?php endif ?>

<style>
    /* Targeting the dropdown options */
    .nice-select .list {
        max-height: 200px;
        /* Set maximum height for dropdown */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }
</style>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Profile</h4>
                    <div class="breadcrumb__links">
                        <a href="<?= base_url('home') ?>">Home</a>
                        <span>Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <!-- contact -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Profile</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('profile') ?>" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" id="name" value="<?= $data['full_name'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">No. HP</label>
                                <input type="text" class="form-control" name="phone" id="subject" value="<?= $data['phone'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="new_password" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="confirm_password" id="subject" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<br />
<!-- Shopping Cart Section End -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<?= $this->endSection(); ?>