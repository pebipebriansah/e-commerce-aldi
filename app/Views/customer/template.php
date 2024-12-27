<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('customer/') ?>css/style.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- render header -->
    <?= $this->renderSection('header'); ?>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="#">Sign in</a>
                <a href="#">FAQs</a>
            </div>
            <div class="offcanvas__top__hover">
                <span>Usd <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>USD</li>
                    <li>EUR</li>
                    <li>USD</li>
                </ul>
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="<?= base_url('customer/') ?>img/icon/search.png" alt=""></a>
            <a href="#"><img src="<?= base_url('customer/') ?>img/icon/heart.png" alt=""></a>
            <a href="#"><img src="<?= base_url('customer/') ?>img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price">$0.00</div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="./index.html"><img src="<?= base_url('customer/') ?>img/logo.png" alt="" style="height: 60%; width: 60%;"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="<?= $title == 'Home' ? 'active' : '' ?>"><a href="<?= base_url('/') ?>">Home</a></li>
                            <li class="<?= $title == 'Shop' ? 'active' : '' ?>"><a href="<?= base_url('shop') ?>">Shop</a></li>
                            <li><a href="#">Category</a>
                                <ul class="dropdown" id="dropdownCategory">
                                </ul>
                            </li>
                            <li><a href="<?= base_url('contact') ?>">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="<?= base_url('cart') ?>"><img src="<?= base_url('customer/') ?>img/icon/cart.png" alt=""> <span>0</span></a>
                        <!-- profile -->
                        <?php if (session()->get('isLoggedIn') == true) : ?>
                            <!-- jika sudah login -->
                            <div class="price" id="dropdownButton">
                                <?= session()->get('full_name') ?> <i class="arrow_carrot-down"></i>
                                <ul id="dropdownMenu">
                                    <li><a href="<?= base_url('profile') ?>">Profil Saya</a> </li>
                                    <li><a href="<?= base_url('shop/order') ?>">Pesanan Saya</a> </li>
                                    <li><a href="<?= base_url('logout-customer') ?>">Logout</a> </li>
                                </ul>
                            </div>
                        <?php else : ?>

                            <a class="btn btn-dark" href="<?= base_url('customer/login') ?>">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    <?= $this->renderSection('content'); ?>

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="<?= base_url('customer/') ?>img/logo.png" alt=""></a>
                        </div>
                        <p>Jl. Raya Siliwangi, Ciawigebang, Kec. Ciawigebang, Kabupaten Kuningan, Jawa Barat</p>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shop</h6>
                        <ul>
                            <li><a href="#">Kategori</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            AyHijab Store
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="<?= base_url('customer/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/jquery.nice-select.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/jquery.nicescroll.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/jquery.magnific-popup.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/jquery.countdown.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/jquery.slicknav.js"></script>
    <script src="<?= base_url('customer/') ?>js/mixitup.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/owl.carousel.min.js"></script>
    <script src="<?= base_url('customer/') ?>js/main.js"></script>

    <?= $this->renderSection('script'); ?>

    <script>
        getCategory();
        // Toggle dropdown on click
        document.getElementById('dropdownButton').addEventListener('click', function(event) {
            event.stopPropagation(); // Mencegah event klik untuk bubbling ke elemen di luar
            document.getElementById('dropdownMenu').classList.toggle('show');
        });

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', function(event) {
            var dropdownButton = document.getElementById('dropdownButton');
            var dropdownMenu = document.getElementById('dropdownMenu');
            var isClickInside = dropdownButton.contains(event.target) || dropdownMenu.contains(event.target);

            if (!isClickInside) {
                dropdownMenu.classList.remove('show');
            }
        });

        // Get count cart
        function getCountCart() {
            fetch('<?= base_url('cart/count') ?>')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.header__nav__option a span').textContent = data.count;
                });
        }

        // Get category
        function getCategory() {
            fetch('<?= base_url('get-category') ?>')
                .then(response => response.json())
                .then(data => {

                    console.log(data);
                    let category = '';
                    data.forEach(item => {
                        category += `<li><a href="<?= base_url('shop') ?>?category=${item.id}">${item.name}</a></li>`;
                    });
                    document.getElementById('dropdownCategory').innerHTML = category;
                }).catch(error => {
                    console.error('Error:', error);
                });
        }

        // jalankan get count cart
        getCountCart();
    </script>
</body>

</html>