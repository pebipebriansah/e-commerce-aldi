<?= $this->extend('customer/template'); ?>

<!-- render heder -->
<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

<style>
    #star-rating .fa-star {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
    }

    #star-rating .fa-star.selected {
        color: gold;
    }

    #star-rating .fa-star:hover {
        color: gold;
    }
</style>


<!-- sweet alert -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>'
        });
    </script>
<?php elseif (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    </script>
<?php endif; ?>

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
                            <div>
                                <p class="badge badge-warning"><?= strtoupper($order['status']) ?></p>
                                <!-- jika status shipped tampilkan button pesanan diterima -->
                                <?php if ($order['status'] == 'shipped') : ?>
                                    <a href="<?= base_url('shop/order/confirm/' . $order['id']) ?>" class="btn btn-success">Pesanan Diterima</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <span>Penerima: <?= $order['user_name'] ?></span>
                                <br>
                                <!-- no hp -->
                                <span>No. Telp: <?= $order['phone'] ?> </span>
                                <br>
                                <span>Alamat Pengiriman: <?= $order['shipping_address'] ?></span>
                                <br>
                                <span>Ekspedisi: <?= strtoupper($order['expedisi']) . ' - ' . $order['estimasi'] ?></span>
                                <br>
                                <?php if ($order['resi']) : ?>
                                    <span>No. Resi: <?= $order['resi'] ?></span>
                                <?php endif; ?>
                                <br>
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

                                    <?php if ($order['status'] == 'completed') : ?>
                                        <th scope="col">Review</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_item as $item): ?>
                                    <tr>
                                        <td><img src="<?= base_url('produk/' . $item['product_image']) ?>" alt="" style="width: 100px; height: 100px;"></td>
                                        <td><?= $item['product_name'] . ' - ' . $item['product_size'] . ' - ' . $item['product_color'] ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                        <?php if ($order['status'] == 'completed') : ?>
                                            <td><button class="btn btn-success" onclick="review(<?= $item['id'] ?>, <?= $order['id'] ?>)">Review</button></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="<?= ($order['status'] == 'completed' ? '4' : '3') ?>" class="text-right">Biaya Kirim :</td>
                                    <td>Rp <?= number_format($order['cost'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td colspan="<?= ($order['status'] == 'completed' ? '4' : '3') ?>" class="text-right">Total :</td>
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
                                    <input type="file" class="form-control-file" id="bukti" name="bukti" onchange="previewImage(event)">
                                </div>
                                <div class="form-group">
                                    <img id="preview" src="#" alt="Pratinjau Gambar" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </form>
                        <?php else: ?>
                            <!-- show image -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        Bukti Pembayaran
                                        <span class="badge badge-warning"><?= strtoupper($data['pembayaran']['payment_status']) ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <img src="<?= base_url('bukti/' . $data['pembayaran']['bukti_transfer']) ?>" alt="" style="max-width: 200px; max-height: 200px;">
                                    <br>
                                </div>
                            </div>
                        <?php endif; ?>
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
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Tampilkan elemen gambar
            };
            reader.readAsDataURL(input.files[0]); // Baca file yang dipilih
        }
    }

    function review(id, idOrder) {
        Swal.fire({
            title: 'Review Produk',
            html: `
            <form action="<?= base_url('shop/review') ?>" method="post" id="reviewForm">
                <input type="hidden" name="order_item_id" value="${id}">
                <input type="hidden" name="order_id" value="${idOrder}">
                <div class="form-group">
                    <div id="star-rating">
                        <i class="fa fa-star" data-value="1"></i>
                        <i class="fa fa-star" data-value="2"></i>
                        <i class="fa fa-star" data-value="3"></i>
                        <i class="fa fa-star" data-value="4"></i>
                        <i class="fa fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="rating" value="0">
                </div>
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea name="review" id="review" class="form-control" placeholder="Tulis ulasan Anda"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        `,
            showCancelButton: false,
            showConfirmButton: false,
            didRender: () => {
                // Handle star click events
                const stars = document.querySelectorAll('#star-rating .fa-star');
                const ratingInput = document.getElementById('rating');

                stars.forEach((star, index) => {
                    star.addEventListener('click', () => {
                        const value = index + 1;
                        ratingInput.value = value;

                        // Update star styles
                        stars.forEach((s, i) => {
                            s.classList.toggle('selected', i < value);
                        });
                    });
                });
            }
        });
    }
</script>
<?= $this->endSection(); ?>