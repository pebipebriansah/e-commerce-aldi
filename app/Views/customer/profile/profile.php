<?= $this->extend('customer/template'); ?>

<!-- render heder -->
<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<style>
    .tom-select-wrapper {
    display: block;
}

.tom-select {
    width: 100%;
    min-height: 38px;
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 6px 12px;
    font-size: 14px;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.tom-select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

</style>
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
                                <label for="subject" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="subject" value="<?= $data['address'] ?>" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="alamatSelect" class="form-label">Alamat</label>
                                <select id="alamatSelect" name="alamat"></select>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="new_password" id="subject">
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="confirm_password" id="subject">
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
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    document.querySelectorAll(".nice-select").forEach(function(el) {
    el.remove(); // Hapus elemen Nice Select yang sudah dibuat
});

    // Pastikan elemen asli tersembunyi sebelum Tom Select diinisialisasi
    const selectElement = document.querySelector("#alamatSelect");
    if (selectElement) {
        selectElement.style.display = "none"; // Sembunyikan elemen asli
    }

    // Inisialisasi Tom Select
    new TomSelect("#alamatSelect", {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        load: function(query, callback) {
            if (!query.length) return callback();
            fetch('/alamat?term=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(json => {
                    callback(json.results);
                })
                .catch(() => {
                    callback();
                });
        },
        placeholder: 'Masukan Desa...'
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        const passwordField = document.querySelector("input[name='new_password']");
        const confirmPasswordField = document.querySelector("input[name='confirm_password']");

        form.addEventListener("submit", function (e) {
            if (passwordField.value && !confirmPasswordField.value) {
                e.preventDefault(); // Mencegah pengiriman form
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Konfirmasi Password harus diisi jika Password Baru diisi',
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>