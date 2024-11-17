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
            <form action="<?= base_url('pesan') ?>" method="POST">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="checkout__title">Pengiriman</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Provinsi<span>*</span></p>

                                    <select class="form-control" name="prov">
                                        <option value="">Pilih Provinsi</option>
                                        <?php foreach ($provinsi as $prov) : ?>
                                            <option value="<?= $prov['province'] ?>" id_provinsi="<?= $prov['province_id'] ?>"><?= $prov['province'] ?></option>
                                        <?php endforeach ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Kabupaten/Kota<span>*</span></p>
                                    <select name="kab" class="form-control">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input mt-3">
                            <p>Kecamatan<span>*</span></p>
                            <input type="kecamatan" name="kecamatan">
                        </div>
                        <div class="checkout__input mt-2">
                            <p>Alamat Lengkap<span>*</span></p>
                            <input type="text" placeholder="Alamat Lengkap" class="checkout__input__add" name="alamat_lengkap">
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
                        <!-- <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Country/State<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="acc">
                                Create an account?
                                <input type="checkbox" id="acc">
                                <span class="checkmark"></span>
                            </label>
                            <p>Create an account by entering the information below. If you are a returning customer
                                please login at the top of the page</p>
                        </div>
                        <div class="checkout__input">
                            <p>Account Password<span>*</span></p>
                            <input type="text">
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="diff-acc">
                                Note about your order, e.g, special noe for delivery
                                <input type="checkbox" id="diff-acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input">
                            <p>Order notes<span>*</span></p>
                            <input type="text"
                                placeholder="Notes about your order, e.g. special notes for delivery.">
                        </div> -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">Pesanan Anda</h4>
                            <div class="checkout__order__products">Product <span>Total</span></div>
                            <ul class="checkout__total__products">
                                <?php
                                $subtotal = 0;
                                foreach ($produk as $item): ?>
                                    <li> <?= $item['name'] . ' - ' . $item['size'] . '/' . $item['color'] ?> <span>Rp. <?= $item['price'] ?></span></li>
                                    <?php $subtotal += $item['price'] ?>
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
                                    Direct Bank Transfer
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
    $(document).ready(function() {
        // Ketika provinsi dipilih
        $('select[name="prov"]').on('change', function() {
            var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
            console.log("ID Provinsi yang dipilih: " + id_provinsi_terpilih);

            $.ajax({
                type: "POST",
                url: "<?= base_url('kabupaten') ?>", // Pastikan URL ini benar
                data: 'id_provinsi=' + id_provinsi_terpilih,
                success: function(hasil_kota) {
                    console.log("Response kabupaten: " + hasil_kota); // Periksa output di konsol

                    $("select[name=kab]").empty().append(hasil_kota);

                    // Inisialisasi ulang nice-select setelah update
                    $('select').niceSelect('update');

                }
            });
        });

        // Ketika ekspedisi dipilih
        $('select[name="ekspedisi"]').on('change', function() {
            var id_kota = $("option:selected", 'select[name="kab"]').attr("id_kota");
            var ekspedisi = $("option:selected", this).val();
            console.log("ID Kota yang dipilih: " + id_kota);
            console.log("Ekspedisi yang dipilih: " + ekspedisi);

            $.ajax({
                type: "POST",
                url: "<?= base_url('ongkir') ?>", // Pastikan URL ini benar
                data: 'id_kota=' + id_kota + '&expedisi=' + ekspedisi,
                success: function(hasil_ongkir) {
                    console.log("Response ongkir: " + hasil_ongkir); // Periksa output di konsol

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

            // hitung total
            var subtotal = <?= $subtotal ?>;
            var total = parseInt(ongkir) + subtotal;
            console.log("Total: " + total);
            $('#total').text('Rp. ' + total);
        });
    });
</script>
<?= $this->endSection(); ?>