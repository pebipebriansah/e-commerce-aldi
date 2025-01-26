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
                                <label for="detailAlamat" class="form-label">Detail Alamat</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="detailAlamat" 
                                    value="<?= $data['address_detail'] ?>" 
                                    readonly 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="alamatSekarang" class="form-label">Alamat Sekarang</label>
                                <div class="d-flex flex-column">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="alamatSekarang" 
                                        value="<?= $data['address'] ?>" 
                                        readonly 
                                        required
                                    >
                                    <a 
                                        href="#" 
                                        id="editAlamatLink" 
                                        class="text-primary mt-2"
                                    >
                                        Edit Alamat
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3" id="addressSelectContainer" style="display: none;">
                                <label for="detailAddress" class="form-label">Detail</label>
                                <input type="text" id="detailAddress" class="form-control" name="detail_alamat" placeholder="Contoh : Jl. / Patokan. RT/Rw">
                            </div>
                            <div class="mb-3" id="alamatSelectContainer" style="display: none;">
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
        el.remove();
    });

    // Debugging langkah pertama
    console.log('Script dimuat.');

    // Cek keberadaan elemen
    const editAlamatLink = document.getElementById('editAlamatLink');
    const alamatSelectContainer = document.getElementById('alamatSelectContainer');
    const addressSelectContainer = document.getElementById('addressSelectContainer');
    const alamatSelect = document.getElementById('alamatSelect');

    if (!editAlamatLink || !alamatSelectContainer || !alamatSelect) {
        console.error('Salah satu elemen tidak ditemukan!');
    }

    // Event klik untuk tombol "Edit Alamat"
    editAlamatLink.addEventListener('click', function (e) {
        e.preventDefault(); // Hindari reload halaman
        console.log('Tombol Edit Alamat diklik.');

        // Toggle visibilitas dropdown
        if (alamatSelectContainer.style.display === 'none') {
            alamatSelectContainer.style.display = 'block'; // Tampilkan dropdown
            addressSelectContainer.style.display = 'block'; // Sembunyikan input detail alamat
            editAlamatLink.textContent = 'Batal'; // Ubah teks ke "Batal"
            console.log('AlamatSelectContainer ditampilkan, tombol diubah menjadi "Batal".');
        } else {
            alamatSelectContainer.style.display = 'none'; // Sembunyikan dropdown
            addressSelectContainer.style.display = 'none'; // Sembunyikan input detail alamat
            editAlamatLink.textContent = 'Edit Alamat'; // Ubah teks ke "Edit Alamat"
            console.log('AlamatSelectContainer disembunyikan, tombol diubah menjadi "Edit Alamat".');
        }
    });

    // Inisialisasi Tom Select
    new TomSelect("#alamatSelect", {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        placeholder: 'Masukkan Desa...',
        load: function (query, callback) {
            if (!query.length) return callback();
            fetch('/alamat?term=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(json => {
                    callback(json.results);
                }).catch(() => {
                    callback();
                });
        }
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