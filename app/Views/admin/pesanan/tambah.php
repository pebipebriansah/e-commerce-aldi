        <!-- use template -->
        <?= $this->extend('admin/template'); ?>
        <?= $this->section('content'); ?>
        <!--  Row 1 -->
        <!-- session getFlashData -->
        <?php if (session()->getFlashData('success')) : ?>
            <!-- sweetalert -->
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '<?= session()->getFlashData('success') ?>',
                });
            </script>
        <?php endif; ?>
        <?php if (session()->getFlashData('error')) : ?>
            <!-- sweetalert -->
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '<?= session()->getFlashData('error') ?>',
                });
            </script>
        <?php endif; ?>
        <div class="row" id="app">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Tambah Pesanan</h5>
                        <h6>Data Pembeli</h6>
                        <form action="<?= base_url('admin/pesanan/add') ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                            <?= csrf_field() ?> <!-- CSRF protection -->
                            <input type="text" name="total_harga" id="total-harga-input" hidden>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tanggal Pembelian</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Pembeli</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukan Nama Pembeli" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Masukan Alamat" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">No. Hp</label>
                                <input type="text" class="form-control" name="no_hp" id="name" placeholder="Masukan No. Hp" required>
                            </div>
                            <h6>Data Produk</h6>
                            <!-- data produk -->
                            <div id="variant-wrapper">
                                <div class="mt-3">
                                    <div class="alert alert-primary">
                                        <h6>Total Harga: Rp <span id="total-harga">0</span></h6>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary mb-3" id="add-variant-btn">Tambah Produk</button>
                            <br>
                            <!-- Upload Gambar -->

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <style>
            .image-preview-container {
                position: relative;
                width: 100px;
                height: 100px;
                overflow: hidden;
                border: 1px solid #ddd;
                border-radius: 8px;
            }

            .image-preview-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-preview-container .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                width: 18px;
                background: rgba(255, 0, 0, 0.8);
                color: white;
                border: none;
                border-radius: 50%;
                cursor: pointer;
            }
        </style>
        <!-- Modal -->
        <?= $this->endSection(); ?>

        <?= $this->section('script'); ?>
        <!-- Script untuk menambah varian secara dinamis -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const produkSelectTemplate = `
        <option value="" selected disabled>Pilih Produk</option>
    `;

                let totalHargaElem = document.getElementById('total-harga');
                // masukan total harga ke input hidden
                let totalHargaInput = document.getElementById('total-harga-input');
                // Fungsi untuk menghitung total harga
                function updateTotalHarga() {
                    let totalHarga = 0;
                    const variantItems = document.querySelectorAll('.variant-item');

                    variantItems.forEach((item) => {
                        const hargaInput = item.querySelector('input[name="harga[]"]');
                        const qtyInput = item.querySelector('input[name="qty[]"]');

                        const harga = parseFloat(hargaInput.value) || 0;
                        const qty = parseInt(qtyInput.value) || 0;

                        totalHarga += harga * qty;
                    });

                    totalHargaElem.textContent = totalHarga.toLocaleString('id-ID'); // Format ke Rupiah
                    totalHargaInput.value = totalHarga;
                }

                // Ambil data produk dari server saat halaman dimuat
                fetch('<?= base_url('admin/pesanan') ?>/getProduk')
                    .then((response) => response.json())
                    .then((data) => {
                        // Simpan data produk untuk digunakan nanti
                        window.produkList = data;
                    })
                    .catch((error) => {
                        console.error('Error fetching produk:', error);
                    });

                document.getElementById('add-variant-btn').addEventListener('click', function() {
                    const variantWrapper = document.getElementById('variant-wrapper');

                    const newVariant = document.createElement('div');
                    newVariant.classList.add('variant-item', 'row', 'mb-3');

                    newVariant.innerHTML = `
            <div class="col-md-3">
                <label class="form-label">Produk</label>
                <select name="produk[]" class="form-control produk-select">
                    ${produkSelectTemplate}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Variasi Produk</label>
                <select name="variasi[]" class="form-control variasi-select">
                    <option value="" selected>Pilih Variasi</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" class="form-control" name="harga[]" value="0" required readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Diskon (%)</label>
                <input type="number" class="form-control" name="diskon[]" value="0" required readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Qty</label>
                <input type="number" class="form-control" name="qty[]" value="1" required>
            </div>
        `;
                    variantWrapper.appendChild(newVariant);

                    const produkSelect = newVariant.querySelector('.produk-select');
                    const variasiSelect = newVariant.querySelector('.variasi-select');
                    const inputHarga = newVariant.querySelector('input[name="harga[]"]');
                    const inputDiskon = newVariant.querySelector('input[name="diskon[]"]');
                    const qtyInput = newVariant.querySelector('input[name="qty[]"]');

                    if (window.produkList) {
                        window.produkList.forEach((produk) => {
                            const option = document.createElement('option');
                            option.value = produk.id;
                            option.textContent = produk.name;
                            produkSelect.appendChild(option);
                        });
                    }

                    produkSelect.addEventListener('change', function() {
                        const produkId = this.value;

                        fetch(`<?= base_url('admin/pesanan') ?>/getVariasiProduk/${produkId}`)
                            .then((response) => response.json())
                            .then((data) => {
                                variasiSelect.innerHTML = '<option value="" selected>Pilih Variasi</option>';

                                data.forEach((item) => {
                                    const option = document.createElement('option');
                                    option.value = JSON.stringify(item);
                                    option.textContent = `${item.size} | ${item.color} | Rp. ${item.price} | Stok: ${item.stock} | ${item.discount}%`;
                                    variasiSelect.appendChild(option);
                                });
                            })
                            .catch((error) => {
                                console.error('Error fetching variations:', error);
                            });
                    });

                    variasiSelect.addEventListener('change', function() {
                        const selectedOption = this.value;
                        if (selectedOption) {
                            const selectedVariation = JSON.parse(selectedOption);
                            const harga = selectedVariation.price - (selectedVariation.price * selectedVariation.discount / 100);

                            inputHarga.value = harga;
                            inputDiskon.value = selectedVariation.discount;

                            updateTotalHarga();
                        }
                    });

                    qtyInput.addEventListener('input', updateTotalHarga);
                });

                updateTotalHarga();
            });
        </script>
        <?= $this->endSection(); ?>