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
                    <h5 class="card-title fw-semibold">Pesanan</h5>
                    <a href="<?= base_url('admin/pesanan/add') ?>" class="btn btn-primary">+ Tambah Pesanan</a>
                </div>
                <nav class="nav nav-pills flex-column flex-sm-row mb-4">
                    <a class="flex-sm-fill text-sm-center nav-link <?= $keyword == 'pending' ? 'active' : '' ?>" aria-current="page" href="?status=pending">Belum Bayar </a>
                    <a class="flex-sm-fill text-sm-center nav-link <?= $keyword == 'paid' ? 'active' : '' ?>" href="?status=paid">Dikemas</a>
                    <a class="flex-sm-fill text-sm-center nav-link <?= $keyword == 'shipped' ? 'active' : '' ?>" href="?status=shipped">Dikirim</a>
                    <a class="flex-sm-fill text-sm-center nav-link <?= $keyword == 'completed' ? 'active' : '' ?>" href="?status=completed">Selesai</a>
                    <a class="flex-sm-fill text-sm-center nav-link <?= $keyword == 'cancelled' ? 'active' : '' ?>" href="?status=cancelled">Dibatalkan</a>
                </nav>
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tanggal</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">No. Order</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Customer</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Total Pesanan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-center">Aksi</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $item) : ?>
                                <!-- jika status belum bayar -->
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['order_date'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['no_order'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['user_name'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success rounded-3 fw-semibold">Rp. <?= number_format($item['total'], 0, ',', '.') ?></span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success rounded-3 fw-semibold"><?= $item['status'] ?></span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex justify-content-center">
                                            <a href="<?= base_url('admin/pesanan/' . $item['id']) ?>" class="btn btn-primary"><i class="ti ti-eye"></i></a>
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
    let table2 = new DataTable('#dikemas');

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
                fetch('<?= base_url('admin/kategori/delete') ?>', {
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