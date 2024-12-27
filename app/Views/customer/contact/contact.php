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
                    <h4>Contact</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.html">Home</a>
                        <span>Contact</span>
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
            <!-- contact -->
            <div class="container">
                <div class="row">
                    <!-- Contact Section Begin -->
                    <div class="col-lg-8 col-md-12 mx-auto">
                        <div class="contact-form">
                            <h2 class="text-center mb-4">Hubungi Kami</h2>
                            <p class="text-center">Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami melalui form di bawah ini atau langsung ke alamat kami.</p>
                            <form onsubmit="sendEmail(event)">
                                <div class="form-group">
                                    <label for="name">Nama Anda</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama Anda" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Anda</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Pesan Anda</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                    <!-- Contact Information -->
                    <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                        <h4>Informasi Kontak</h4>
                        <ul class="list-unstyled">
                            <li>
                                <strong>Nama Toko:</strong><br>
                                Ay Hijab Store
                            </li>
                            <li>
                                <strong>Alamat:</strong><br>
                                Jl. Raya Siliwangi, Ciawigebang, Kec. Ciawigebang, Kabupaten Kuningan, Jawa Barat
                            </li>
                            <li>
                                <strong>Email:</strong><br>
                                storeayhijab@gmail.com
                            </li>
                            <li>
                                <strong>WA/Telepon:</strong><br>
                                <a href="https://api.whatsapp.com/send/?phone=6287880486408&text=Hallo%20kak%2C%20saya%20ingin%20bertanya%20sesuatu%20dong%20%F0%9F%98%81&type=phone_number&app_absent=0">+62 878-8048-6408</a>
                            </li>
                        </ul>
                        <h4>Lokasi Kami</h4>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15841.215353846515!2d108.5881419!3d-6.9734347!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1303cf50cbb9%3A0xa3c0aa3a53ba885f!2sAy%20Hijab%20Store!5e0!3m2!1sid!2sid!4v1733041432723!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <!-- Contact Section End -->
                </div>
            </div>

            <script>
                function sendEmail(event) {
                    event.preventDefault(); // Mencegah form dikirim ke server

                    // Mengambil nilai input
                    var name = document.getElementById("name").value;
                    var email = document.getElementById("email").value;
                    var message = document.getElementById("message").value;

                    // Menyusun isi email
                    var subject = "Pesan Baru dari " + name;
                    var body = "Nama: " + name + "%0A" + // %0A adalah newline di email
                        "Email: " + email + "%0A%0A" +
                        "Pesan:%0A" + message;

                    // Membuka aplikasi email
                    window.location.href = "mailto:storeayhijab@gmail.com?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                }
            </script>
        </div>
    </div>
</section>
<br />
<!-- Shopping Cart Section End -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<?= $this->endSection(); ?>