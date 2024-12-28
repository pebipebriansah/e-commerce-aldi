<!-- use template -->
<?= $this->extend('admin/template'); ?>

<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- sweet alert -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
        })
    </script>
<?php endif ?>
<!--  Row 1 -->
<div class="row" id="app">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold">Daftar Produk</h5>
                    <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i>Tambah Produk</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-start">Gambar Produk</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Produk</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Harga</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-center">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td class="border-bottom-0 ">
                                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner ">
                                                <?php foreach ($item['image'] as $img) : ?>
                                                    <div class="carousel-item <?= $img['is_primary'] == 1 ? 'active' : '' ?>">
                                                        <img src="<?= base_url('produk/' . $img['image']) ?>" class="rounded float-start" alt="..." style="width: 100px;">
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['name'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <select name="" id="" class="form-select">
                                            <?php foreach ($item['size'] as $variant) : ?>
                                                <?php
                                                // menghitung diskon
                                                $diskon = $variant['price'] * $variant['discount'] / 100;
                                                $diskon = $variant['price'] - $diskon;
                                                // mengubah format angka menjadi rupiah
                                                $diskonFormated = number_format($diskon, 0, ',', '.');
                                                ?>
                                                <option value="<?= $variant['price'] ?>"><?= $variant['size'], ' - ', 'Rp. ', $diskonFormated, ' - ', $variant['color'], ' - ', 'Disc ', $variant['discount'], '%', ' - ', 'Stok:', $variant['stock'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex justify-content-center">
                                            <a href="<?= base_url('admin/produk/edit/' . $item['produk_id']) ?>" class="btn btn-primary me-2"><i class="ti ti-eye"></i> </a>
                                            <button class="btn btn-danger me-2" onclick="deleteKategori(<?= $item['produk_id'] ?>)"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script>
    let table = new DataTable('#myTable');

    deleteKategori = (id) => {
        console.log(id);
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengkonfirmasi, lakukan fetch untuk hapus data
                fetch('<?= base_url('admin/produk/delete') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: id
                        })
                    }).then(res => res.json())
                    .then(res => {
                        if (res.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message,
                            });
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menghapus data.',
                        });
                    });
            }
        });
    }
</script>
<?= $this->endSection(); ?>