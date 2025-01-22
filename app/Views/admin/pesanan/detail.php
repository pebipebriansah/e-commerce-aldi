<!-- use template -->
<?= $this->extend('admin/template'); ?>
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
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
        })
    </script>
<?php endif; ?>
<!--  Row 1 -->
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="card-title">
                    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                        <h5 class=" fw-semibold">Detail Pesanan</h5>
                        <!-- btn konfirmasi pesanan -->
                        <?php if ($data['order']['status'] == 'pending') : ?>
                            <a href="<?= base_url('admin/pesanan/konfirmasi/' . $data['order']['id']) ?>" class="btn btn-primary">Konfirmasi Pesanan</a>
                        <?php elseif ($data['order']['status'] == 'paid'): ?>
                            <!-- button modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Kirim Pesanan
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h6>Nama: <?= $data['order']['user_name'] ?></h6>
                                <h6>No. Telp: <?= $data['order']['phone'] ?></h6>
                                <!-- alamat -->
                                <h6>Alamat: <?= $data['order']['shipping_address'] ?></h6>
                                <h6>Ekspedisi: <?= strtoupper($data['order']['expedisi']) . ' - ' . $data['order']['estimasi'] ?></h6>
                            </div>
                            <div class="col-6">

                                <h6>Tanggal: <?= $data['order']['order_date'] ?></h6>
                                <h6>Metode Pembayaran: <?= $data['order']['payment_method'] ?></h6>
                                <!-- status pembayaran -->
                                <?php if ($data['order']['status'] == 'pending') : ?>
                                    <h6>Status Pembayaran: <span class="badge bg-danger">Belum Bayar</span></h6>
                                <?php elseif ($data['order']['status'] == 'paid') : ?>
                                    <h6>Status Pembayaran: <span class="badge bg-warning">Telah Membayar</span></h6>
                                <?php elseif ($data['order']['status'] == 'shipped') : ?>
                                    <h6>Status Pesanan: <span class="badge bg-success">Dalam Pengiriman</span></h6>
                                <?php elseif ($data['order']['status'] == 'completed') : ?>
                                    <h6>Status Pesanan: <span class="badge bg-success">Selesai</span></h6>
                                <?php endif; ?>
                                <h6>Nomor resi: <?= $data['order']['resi'] ?? 'Belum Ada Resi' ?></h6>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-start">Produk</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Qty</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0 text-start">Harga</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($data['order_item'] as $item) : ?>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1"><?= $item['quantity'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">Rp. <?= number_format($item['price'], 0, ',', '.') ?></h6>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>
                                    <h6 class="fw-semibold mb-1">Biaya Ongkos Kirim : </h6>
                                </td>
                                <td></td>
                                <td>
                                    <h6 class="fw-semibold mb-1">Rp. <?= number_format($data['order']['cost'], 0, ',', '.') ?></h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="fw-semibold mb-1">Total Pembayaran : </h6>
                                </td>
                                <td></td>
                                <td>
                                    <h6 class="fw-semibold mb-1">Rp. <?= number_format($data['order']['total'], 0, ',', '.') ?></h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- card foto bukti pembayaran -->
                    <div class="card">
                        <div class="card-body">
                            <h5>Bukti Pembayaran</h5>
                            <?php if ($data['pembayaran'] == null) : ?>
                                <h5>Belum Ada Bukti Pembayaran.</h5>
                            <?php else : ?>
                                <img src="<?= base_url('bukti/' . $data['pembayaran']['bukti_transfer']) ?>" alt="bukti transfer" class="img-fluid" style="width: 150px; lenght:150px;">
                            <?php endif ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kirim Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url('admin/pesanan/kirim/' .  $data['order']['id']) ?>" method="post">
                    <div class="mb-3">
                        <label for="resi" class="form-label">Nomor Resi</label>
                        <input type="text" class="form-control" id="resi" name="resi" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Script untuk menambah varian secara dinamis -->

<?= $this->endSection(); ?>