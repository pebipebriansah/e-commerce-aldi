<?= $this->extend('customer/template'); ?>

<?= $this->section('content'); ?>
<style>
    .coret {
        text-decoration: line-through;
        color: #888;
        /* Opsional: Mengatur warna agar lebih pudar */
    }
</style>
<!-- Hero Section Begin -->
<section class="hero">
    <div class="hero__slider owl-carousel">
        <div class="hero__items set-bg" data-setbg="<?= base_url('customer/') ?>img/hero/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Summer Collection</h6>
                            <h2>Fall - Winter Collections 2030</h2>
                            <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                            <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__items set-bg" data-setbg="<?= base_url('customer/') ?>img/hero/hero-2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Summer Collection</h6>
                            <h2>Fall - Winter Collections 2030</h2>
                            <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                            <a href="#" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                            <div class="hero__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Product Section Begin -->
<section class="product spad mt-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Best Sellers</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".hot-sales">Hot Sales</li>
                </ul>
            </div>
        </div>
        <div class="row product__filter">
            <?php foreach ($produk as $item): ?>
                <?php
                // menghitung diskon
                // cari diskon terbesar
                $maxDiscount = 0;
                foreach ($item['size'] as $variant) {
                    if ($variant['discount'] > $maxDiscount) {
                        $maxDiscount = $variant['discount'];
                    } else {
                        $maxDiscount = $maxDiscount;
                    }
                }
                $diskon = $variant['price'] * $maxDiscount / 100;
                $diskon = $variant['price'] - $diskon;
                ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6">
                    <div class="product__item">
                        <a href="<?= base_url('shop/') . $item['produk_id'] ?>">
                            <div class="product__item__pic set-bg" data-setbg="<?= base_url('produk/') . ($item['image'][0]['image']) ?>">
                                <?php if ($maxDiscount > 0) : ?>
                                    <span class="label text-danger">-<?= $maxDiscount ?>%</span>
                                <?php endif ?>
                            </div>
                        </a>
                        <div class="product__item__text">
                            <h6><?= $item['name'] ?></h6>
                            <?php if ($maxDiscount > 0) : ?>
                                <h5 class="text-danger">Rp. <?= number_format($diskon, 0, ',', '.') ?> <span class="coret">Rp. <?= number_format($variant['price'], 0, ',', '.') ?></span></h5>

                            <?php else : ?>
                                <h5>
                                    Rp. <?= number_format($variant['price'], 0, ',', '.') ?>
                                </h5>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    </div>
</section>
<!-- Product Section End -->
<?= $this->endSection(); ?>