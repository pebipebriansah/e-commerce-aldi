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
                    <h5 class="card-title fw-semibold">Promosi</h5>
                    <a href="<?= base_url('admin/promosi/tambah') ?>" class="btn btn-primary"><i class="ti ti-plus"></i>Tambah Promosi</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-start">Banner Promosi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Promosi</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Waktu</h6>
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
                                        <div class="img img-2">
                                            <img src="<?= base_url('promo/' . $item['banner']) ?>" class="rounded float-start" alt="..." style="width: 100px;">
                                        </div>
                                    </td>
                                    <td class="border-bottom-0"><?= $item['promotion_name'] ?></td>
                                    <td class="border-bottom-0"><?= $item['start_date'] . ' - ' . $item['end_date'] ?></td>
                                    <td class="border-bottom-0 text-center">
                                        <a href="<?= base_url('admin/promosi/edit/' . $item['id']) ?>" class="btn btn-primary btn-sm"><i class="ti ti-pencil"></i></a>
                                        <button class="btn btn-danger btn-sm" onclick="deleteKategori(<?= $item['id'] ?>)"><i class="ti ti-trash"></i></button>
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
                fetch('<?= base_url('admin/promosi/delete') ?>', {
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