<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('/admin/assets') ?>/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?= base_url('/admin/assets') ?>/css/styles.min.css" />
    <script src="<?= base_url('/admin/assets') ?>/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <?= $this->renderSection('header'); ?>

</head>

<body>
    <script>
        // request permission

        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('3d6dc9011db726edee70', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            // sound notification
            var audio = new Audio('<?= base_url('/notification.mp3') ?>');
            audio.play();
            // masukkan data ke notification
            // <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center rounded-pill fs-2" id="notif-pesanan">9</span>
            $('#notif-pesanan').html('<span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center rounded-pill fs-2">' + 1 + '</span>');
            // toastr
            toastr.success(data.message, 'Pesanan Baru!', {
                timeOut: 5000
            });
            var notification = new Notification('Pesanan Baru!', {
                body: data.message,
                icon: '<?= base_url('customer/') ?>img/logo.png',
                timestamp: Date.now() //
            });

        });
    </script>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="<?= base_url('customer/') ?>img/logo.png" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <?php if (session()->get('role') == 'admin') : ?>
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Home</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-layout-dashboard"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Kelola Produk</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/produk') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-article"></i>
                                    </span>
                                    <span class="hide-menu">Produk</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/promosi') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-discount"></i>
                                    </span>
                                    <span class="hide-menu">Promosi</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/kategori') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-hanger-2"></i>
                                    </span>
                                    <span class="hide-menu">Kategori</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/pesanan') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-shopping-cart"></i>
                                    </span>
                                    <span class="hide-menu">Pesanan</span>
                                    <div class="hide-menu" id="notif-pesanan">

                                    </div>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/review') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-stars"></i>
                                    </span>
                                    <span class="hide-menu">Review</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Customer</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/customer') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <span class="hide-menu">User</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Pelaporan</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/laporan') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-report"></i>
                                    </span>
                                    <span class="hide-menu">Laporan Transaksi</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php elseif (session()->get('role') == 'owner') : ?>
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Home</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/dashboard') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-layout-dashboard"></i>
                                    </span>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Pelaporan</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url('admin/laporan') ?>" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-report"></i>
                                    </span>
                                    <span class="hide-menu">Laporan Transaksi</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="<?= base_url('/admin/assets') ?>/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a class="btn btn-outline-primary mx-3 mt-2 d-block" onclick="logout()">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <?= $this->renderSection('content'); ?>
                <!-- <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
                </div> -->
            </div>
        </div>
    </div>

    <script src="<?= base_url('/admin/assets') ?>/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('/admin/assets') ?>/js/sidebarmenu.js"></script>
    <script src="<?= base_url('/admin/assets') ?>/js/app.min.js"></script>
    <script src="<?= base_url('/admin/assets') ?>/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="<?= base_url('/admin/assets') ?>/libs/simplebar/dist/simplebar.js"></script>
    <script src="<?= base_url('/admin/assets') ?>/js/dashboard.js"></script>
    <script>
        function logout() {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan keluar dari sistem ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Keluar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('logout') ?>';
                }
            })
        }
    </script>
    <?= $this->renderSection('script'); ?>
</body>

</html>