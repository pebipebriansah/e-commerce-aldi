<?= $this->extend('customer/template'); ?>

<!-- render heder -->
<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

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
                    <h4>Pesanan Saya</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.html">Home</a>
                        <a href="./shop.html">Shop</a>
                        <span>Pesanan Saya</span>
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

            <!-- Loop untuk menampilkan setiap pesanan -->

            <?php $order = $data['order'];
            $order_item = $data['order_item']; ?>

            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>#<?= $order['no_order'] ?></h5>
                            <p class="badge badge-warning"><?= strtoupper($order['status']) ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <span>Penerima: <?= $order['user_name'] ?></span>
                                <br>
                                <span>Alamat Pengiriman: <?= $order['shipping_address'] ?></span>
                                <br>
                                <span>Ekspedisi: <?= strtoupper($order['expedisi']) . ' - ' . $order['estimasi'] ?></span>
                            </div>
                        </div>
                        <!-- tabel data order_item -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Produk</th>

                                    <th scope="col">Qty</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_item as $item): ?>
                                    <tr>
                                        <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                        <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">Biaya Kirim :</td>
                                    <td>Rp <?= number_format($order['cost'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Total :</td>
                                    <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php if (!$data['pembayaran']) : ?>
                            <!-- keterangan nomor rekening -->
                            <div class="alert alert-info" role="alert">
                                Silahkan transfer ke nomor rekening 1234567890 a/n Toko Online
                            </div>
                            <!-- input bukti pengiriman -->
                            <form action="<?= base_url('shop/upload_bukti/' . $order['id']) ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="bukti">Upload Bukti Pengiriman</label>
                                    <input type="file" class="form-control-file" id="bukti" name="bukti">
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</section>
<br />
<!-- Shopping Cart Section End -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<?= $this->endSection(); ?>