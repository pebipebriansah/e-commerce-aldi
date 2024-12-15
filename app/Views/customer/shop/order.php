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
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-5"
                                role="tab">Belum Bayar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Dikemas </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Dikirim </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-8" role="tab">Selesai </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-9" role="tab">Dibatalkan</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-5" role="tabpanel">
                            <div class="product__details__tab__content">
                                <div class="product__details__tab__content__item">
                                    <h5>Daftar Pesanan</h5>
                                    <div class="row">

                                        <!-- Loop untuk menampilkan setiap pesanan -->
                                        <?php foreach ($data as $order): ?>
                                            <?php if ($order['status'] == 'pending') : ?>
                                                <div class="col-12 mt-2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h5>#<?= $order['no_order'] ?></h5>
                                                                <h6><span class="badge badge-warning"><?= strtoupper($order['status']) ?></span></h6>

                                                            </div>
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <?php foreach ($order['item'] as $item): ?>
                                                                        <tr>
                                                                            <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                                                            <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                                                            <td><?= $item['quantity'] ?></td>
                                                                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                            <a href="<?= base_url('shop/order/' . $order['id']) ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                </svg> Detail</a>
                                                            <button class="btn btn-danger" onclick="cancelOrder(<?= $order['id'] ?>)">Batalkan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-6" role="tabpanel">
                            <div class="product__details__tab__content">
                                <div class="product__details__tab__content__item">
                                    <h5>Daftar Pesanan</h5>
                                    <div class="row">
                                        <!-- Loop untuk menampilkan setiap pesanan -->
                                        <?php foreach ($data as $order): ?>
                                            <?php if ($order['status'] == 'paid') : ?>
                                                <div class="col-12 mt-2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h5>#<?= $order['no_order'] ?></h5>
                                                                <h6><span class="badge badge-warning"><?= strtoupper($order['status']) ?></span></h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <?php foreach ($order['item'] as $item): ?>
                                                                        <tr>
                                                                            <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                                                            <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                                                            <td><?= $item['quantity'] ?></td>
                                                                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                            <a href="<?= base_url('shop/order/' . $order['id']) ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                </svg> Detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-7" role="tabpanel">
                            <div class="product__details__tab__content">
                                <div class="product__details__tab__content__item">
                                    <h5>Daftar Pesanan</h5>
                                    <div class="row">
                                        <!-- Loop untuk menampilkan setiap pesanan -->
                                        <?php foreach ($data as $order): ?>
                                            <?php if ($order['status'] == 'shipped') : ?>
                                                <div class="col-12 mt-2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h5>#<?= $order['no_order'] ?></h5>
                                                                <h6><span class="badge badge-warning"><?= strtoupper($order['status']) ?></span></h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <?php foreach ($order['item'] as $item): ?>
                                                                        <tr>
                                                                            <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                                                            <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                                                            <td><?= $item['quantity'] ?></td>
                                                                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                            <a href="<?= base_url('shop/order/' . $order['id']) ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                </svg> Detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-8" role="tabpanel">
                            <div class="product__details__tab__content">
                                <div class="product__details__tab__content__item">
                                    <h5>Daftar Pesanan</h5>
                                    <div class="row">
                                        <!-- Loop untuk menampilkan setiap pesanan -->
                                        <?php foreach ($data as $order): ?>
                                            <?php if ($order['status'] == 'completed') : ?>
                                                <div class="col-12 mt-2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h5>#<?= $order['no_order'] ?></h5>
                                                                <h6><span class="badge badge-warning"><?= strtoupper($order['status']) ?></span></h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <?php foreach ($order['item'] as $item): ?>
                                                                        <tr>
                                                                            <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                                                            <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                                                            <td><?= $item['quantity'] ?></td>
                                                                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                            <a href="<?= base_url('shop/order/' . $order['id']) ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                </svg> Detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-9" role="tabpanel">
                            <div class="product__details__tab__content">
                                <div class="product__details__tab__content__item">
                                    <h5>Daftar Pesanan</h5>
                                    <div class="row">
                                        <!-- Loop untuk menampilkan setiap pesanan -->
                                        <?php foreach ($data as $order): ?>
                                            <?php if ($order['status'] == 'cancelled') : ?>
                                                <div class="col-12 mt-2">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="d-flex justify-content-between">
                                                                <h5>#<?= $order['no_order'] ?></h5>
                                                                <h6><span class="badge badge-warning"><?= strtoupper($order['status']) ?></span></h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
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
                                                                    <?php foreach ($order['item'] as $item): ?>
                                                                        <tr>
                                                                            <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                                                            <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                                                            <td><?= $item['quantity'] ?></td>
                                                                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                            <a href="<?= base_url('shop/order/' . $order['id']) ?>" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                                </svg> Detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <br>
                                        <?php endforeach; ?>
                                        <!-- jika tidak ada $order['status'] == 'cancelled' tampilkan tidak ada pesanan-->

                                    </div>
                                </div>
                            </div>
                        </div>
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
<script>
    function cancelOrder(id) {
        console.log(id);
        // sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak dapat mengembalikan pesanan yang sudah dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Batalkan Pesanan'
        }).then((result) => {
            if (result.isConfirmed) {
                // kirim request ke server
                $.ajax({
                    url: '<?= base_url('shop/order/cancel') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 'success') {
                            Swal.fire(
                                'Pesanan dibatalkan!',
                                'Pesanan anda berhasil dibatalkan.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Pesanan anda gagal dibatalkan.',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection(); ?>