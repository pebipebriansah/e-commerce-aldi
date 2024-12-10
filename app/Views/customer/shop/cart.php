<?= $this->extend('customer/template'); ?>

<?= $this->section('content'); ?>

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4><?= $title ?></h4>
                    <div class="breadcrumb__links">
                        <a href="./index.html">Home</a>
                        <a href="./shop.html">Shop</a>
                        <span><?= $title ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = 0;
                            foreach ($produk as $item) : ?>
                                <tr>
                                    <input type="hidden" id="id" name="id_produk" value="<?= $item['id'] ?>">
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <img src="<?= base_url('produk/' . $item['image']) ?>" alt="" class="img-thumbnail" style="width: 100px; height: 100px;">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6><?= $item['name'] ?></h6>
                                            <h6><?= $item['size'] . ' - ' . $item['color'] ?></h6>
                                            <h5>Rp. <?= number_format($item['price'], 0, ',', '.') ?></h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input type="text" name="qty" value="<?= $item['qty'] ?>" class="cart-qty-input" data-id="<?= $item['id'] ?>">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">Rp. <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    <td class="cart__close"><i class="fa fa-close"></i></td>
                                    <?php $subtotal += $item['subtotal'] ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="<?= base_url('shop') ?>">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn update__btn">
                            <a href="#" onclick="cartUpdate()"> Update cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__total">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Total <span>Rp. <?= number_format($subtotal, 0, ',', '.') ?></span></li>
                        <!-- <li>Total <span>$ 169.50</span></li> -->
                    </ul>
                    <a href="<?= base_url('checkout') ?>" class="primary-btn">Proses Checkout</a>
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
    // delete cart, fetch data
    $('.cart__close').on('click', function() {
        let id = $(this).closest('tr').find('#id').val();
        console.log(id);
        $.ajax({
            url: '<?= base_url('cart/delete') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(res) {
                console.log(res);
                if (res.status == 'success') {
                    // sweetalert
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    });

    // checkout
    function checkOut() {
        // sweetalert
        Swal.fire({
            icon: 'success',
            title: 'Checkout Success',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            location.href = '<?= base_url('checkout') ?>';
        });
    }

    function cartUpdate() {
        // Ambil semua input qty
        const qtyInputs = document.querySelectorAll('.cart-qty-input');
        const cartData = [];

        // Loop melalui semua input qty untuk mengambil id_produk dan qty
        qtyInputs.forEach(input => {
            const idCart = input.getAttribute('data-id');
            const qty = input.value;

            // Masukkan data ke dalam array
            cartData.push({
                id_cart: idCart,
                qty: qty
            });
        });

        // Kirim data ke server menggunakan Fetch API
        fetch('<?= base_url("cart/update") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(cartData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // sweetalert
                    Swal.fire({
                        icon: 'success',
                        title: data.message || 'Berhasil memperbarui keranjang',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    //    swal
                    Swal.fire({
                        icon: 'error',
                        title: data.message || 'Gagal memperbarui keranjang',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Coba lagi.');
            });
    }
</script>
<?= $this->endSection(); ?>