<?= $this->extend('customer/template'); ?>

<!-- render heder -->
<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
                    <h4>Check Out</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.html">Home</a>
                        <a href="./shop.html">Shop</a>
                        <span>Check Out</span>
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
        <div class="checkout__form">
            <form action="<?= base_url('checkout') ?>" method="POST">
                <input type="hidden" name="ongkir">
                <input type="hidden" name="total">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">Pengiriman</h6>
                        <div class="card mb-4">
                            <div class="card-body">
                                <p>Alamat: <?= $alamat ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Ekspedisi<span>*</span></p>
                                    <select class="form-control" name="ekspedisi">
                                        <option value="">Pilih Ekspedisi</option>
                                        <?php foreach ($ekspedisi as $index => $eks) : ?>
                                            <option value="<?= $eks['id'] ?>"><?= $eks['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Estimasi<span>*</span></p>
                                    <select name="estimasi" class="form-control">
                                        <option value="">Pilih Estimasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">Pesanan Anda</h4>
                            <div class="checkout__order__products">Product <span>Total</span></div>
                            <ul class="checkout__total__products">
                                <?php
                                $subtotal = 0;
                                foreach ($produk as $item): ?>
                                    <li> <?= $item['name'] . ' | ' . $item['size'] . ' | ' . $item['color'] . ' | x' . $item['qty'] ?> <span>Rp. <?= $totalPerItem = $item['price'] * $item['qty'] ?></span></li>
                                    <?php $subtotal += $totalPerItem ?>
                                <?php endforeach ?>
                            </ul>
                            <ul class="checkout__total__all">
                                <li>Subtotal <span>Rp. <?= $subtotal ?></span></li>
                                <li>Ongkir <span id="ongkir">-</span></li>
                                <li>Total <span id="total">-</span></li>
                            </ul>
                            <!-- <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua.</p> -->
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Bank Transfer
                                    <input type="checkbox" id="payment" name="payment" value="bank_transfer">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <!-- <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div> -->
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<br />
<!-- Shopping Cart Section End -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script>
    // Ketika ekspedisi dipilih
    $('select[name="ekspedisi"]').on('change', function() {
        var ekspedisi = $(this).val();
        console.log("Ekspedisi: " + ekspedisi);
        $.ajax({
            type: "POST",
            url: "<?= base_url('ongkir') ?>", // Pastikan URL ini benar
            data: '&expedisi=' + ekspedisi,
            success: function(hasil_ongkir) {

                $("select[name=estimasi]").empty().append(hasil_ongkir);

                // Inisialisasi ulang nice-select setelah update
                $('select').niceSelect('update');

            }
        });
    });

    // Ketika estimasi dipilih
    $('select[name="estimasi"]').on('change', function() {
        var ongkir = $("option:selected", this).attr("ongkir");
        // pecah string ongkir
        console.log("Ongkir: " + ongkir);
        // masukkan ongkir ke dalam tag span
        $('#ongkir').text('Rp. ' + ongkir);
        // masukan ke input hidden
        $('input[name="ongkir"]').val(ongkir);


        // hitung total
        var subtotal = <?= $subtotal ?>;
        var total = parseInt(ongkir) + subtotal;
        $('input[name="total"]').val(total);
        console.log("Total: " + total);
        $('#total').text('Rp. ' + total);
    });
</script>
<?= $this->endSection(); ?>