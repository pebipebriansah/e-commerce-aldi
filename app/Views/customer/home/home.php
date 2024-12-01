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
        <div class="hero__items set-bg" data-setbg="<?= base_url('customer/') ?>img/hero/hero-3.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>New Collection</h6>
                            <h2>Hijab Kekinian</h2>
                            <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                            <a href="<?= base_url('shop') ?>" class="primary-btn">Shop now <span class="arrow_right"></span></a>
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
        <div class="hero__items set-bg" data-setbg="<?= base_url('customer/') ?>img/hero/hero-6.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Fashionable</h6>
                            <h2>Nyaman digunakan</h2>
                            <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                commitment to exceptional quality.</p>
                            <a href="<?= base_url('shop') ?>" class="primary-btn">Shop now <span class="arrow_right"></span></a>
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
        <div class="row product__filter">
            <?php foreach ($produk as $item): ?>
                <?php
                // menghitung diskon
                // cari diskon terbesar
                $maxDiscount = 0;
                $variantPrice = 0;
                foreach ($item['size'] as $variant) {
                    if ($variant['discount'] > $maxDiscount) {
                        $maxDiscount = $variant['discount'];
                        $variantPrice = $variant['price'];
                    } else {
                        $maxDiscount = $maxDiscount;
                    }
                }
                $diskon = $variantPrice - ($variantPrice * $maxDiscount / 100);
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
                                <h5 class="text-danger">Rp. <?= number_format($diskon, 0, ',', '.') ?> <span class="coret">Rp. <?= number_format($variantPrice, 0, ',', '.') ?></span></h5>

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
<!-- Ay Hijab Store Section Begin -->
<section class="store-info mt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="<?= base_url('customer/') ?>img/model.png" alt="Hijab Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2>Ay Hijab Store</h2>
                <p>
                    Berkomitmen untuk memberikan kemudahan dalam berbelanja hijab, kami hadir dengan pelayanan terbaik untuk Anda. Nikmati berbagai pilihan hijab berkualitas dan desain modis yang akan membuat setiap pengalaman berbelanja Anda semakin menyenangkan.
                </p>
                <p>
                    Temukan koleksi terbaru yang sesuai dengan gaya Anda, dan biarkan setiap momen berbelanja menjadi pengalaman yang tak terlupakan. Dengan setiap produk, kami menjamin keindahan dan kenyamanan yang sempurna. Kepuasan Anda adalah prioritas utama kami!
                </p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-4 text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-hand-thumbs-up mb-2" viewBox="0 0 16 16">
                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z" />
                </svg>
                <h5>Produk Berkualitas</h5>
                <p>
                    Menawarkan berbagai macam produk hijab dengan bahan berkualitas dan desain trendi, memastikan kenyamanan serta penampilan elegan.
                </p>
            </div>
            <div class="col-md-4 text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-phone mb-2" viewBox="0 0 16 16">
                    <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                </svg>
                <h5>Belanja Mudah dari Mana Saja</h5>
                <p>
                    Nikmati kemudahan belanja online kapan saja, di mana saja, dengan layanan pengiriman cepat langsung ke alamat Anda.
                </p>
            </div>
            <div class="col-md-4 text-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-cash-coin mb-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                </svg>
                <h5>Harga Terjangkau</h5>
                <p>
                    Menawarkan hijab dan busana muslim berkualitas tinggi dengan harga yang terjangkau, sehingga pelanggan dapat tampil stylish tanpa menguras biaya.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
<?= $this->endSection(); ?>