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
                                        <img src="<?= base_url('produk/') . $item['image'] ?>" alt="<?= $item['name'] ?>" class="rounded float-start" style="width:100px">
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['name'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 ">Rp. <?= $item['price'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary me-2"><i class="ti ti-eye"></i></button>
                                            <button class="btn btn-danger" onclick="deleteKategori(<?= $item['produk_id'] ?>)"><i class="ti ti-trash"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/kategori/add') ?>" method="POST">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label
                        ">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label
                        ">Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
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