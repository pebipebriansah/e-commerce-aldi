<!-- use template -->
<?= $this->extend('admin/template'); ?>
<?= $this->section('content'); ?>
<!--  Row 1 -->
<div class="row" id="app">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold">Edit Promosi</h5>
                <form action="<?= base_url('admin/promosi/edit') ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                    <?= csrf_field() ?> <!-- CSRF protection -->

                    <input type="hidden" value="<?= $data['id'] ?>" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Promosi</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $data['promotion_name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local" class="form-control" name="tgl_mulai" value="<?= $data['start_date'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control" name="tgl_selesai" value="<?= $data['end_date'] ?>" required>
                    </div>
                    <!-- Upload Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Banner Promosi</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </div>
                    <div class="mb-1">
                        <!-- Tampilkan Gambar yang Sudah Ada -->
                        <label for="current-images" class="form-label mt-3">Gambar Saat Ini</label>
                        <div class="img img-2">
                            <div class="image-preview-container">
                                <img src="<?= base_url('promo/' . $data['banner']) ?>" alt="Gambar Produk">
                            </div>

                        </div>
                    </div>
                    <div id="image-preview" class="d-flex flex-wrap gap-2 mb-2"></div>
                    <h6>Data Produk</h6>

                    <div id="variant-wrapper">
                        <div id="variant-wrapper">
                            <?php foreach ($produk as $variant): ?>
                                <div class="variant-item row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Produk</label>
                                        <select name="produk[]" class="form-control produk-select">
                                            <!-- Pilihan produk -->
                                            <?php foreach ($produks as $produk): ?>
                                                <option value="<?= $produk['id'] ?>" <?= $produk['id'] == $variant['product_id'] ? 'selected' : '' ?>>
                                                    <?= $produk['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Variasi Produk</label>
                                        <select name="variasi[]" class="form-control variasi-select">
                                            <option value="<?= $variant['id'] ?>" selected>
                                                <?= $variant['size'] ?> | <?= $variant['color'] ?> | Rp. <?= $variant['price'] ?> | Stok: <?= $variant['stock'] ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Diskon (%)</label>
                                        <input type="number" class="form-control" name="diskon[]" value="<?= $variant['discount'] ?>" required>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="add-variant-btn">Tambah Produk</button>
                    <br>
                    <button type="submit" class="btn btn-primary">Simpan Promosi</button>
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
    // Script untuk upload gambar dengan pratinjau dan opsi hapus
    const imageInput = document.getElementById('image');
    const imagePreviewContainer = document.getElementById('image-preview');
    let selectedImages = [];

    imageInput.addEventListener('change', function() {
        selectedImages = Array.from(imageInput.files);
        updateImagePreview();
    });

    function updateImagePreview() {
        imagePreviewContainer.innerHTML = '';
        selectedImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-preview-container');

                const img = document.createElement('img');
                img.src = e.target.result;
                imageContainer.appendChild(img);

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '×';
                removeButton.classList.add('remove-image');
                removeButton.onclick = function() {
                    removeImage(index);
                };
                imageContainer.appendChild(removeButton);

                imagePreviewContainer.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeImage(index) {
        selectedImages.splice(index, 1);
        updateImageInput();
        updateImagePreview();
    }

    function updateImageInput() {
        const dataTransfer = new DataTransfer();
        selectedImages.forEach((file) => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }

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
                <label class="form-label">Diskon (%)</label>
                <input type="number" class="form-control" name="diskon[]" value="0" required>
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
                            option.value = item.id;
                            option.textContent = `${item.size} | ${item.color} | Rp. ${item.price} | Stok: ${item.stock}`;
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