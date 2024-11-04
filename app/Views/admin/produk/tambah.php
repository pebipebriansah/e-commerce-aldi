<!-- use template -->
<?= $this->extend('admin/template'); ?>
<?= $this->section('content'); ?>
<!--  Row 1 -->
<div class="row" id="app">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold">Tambah Produk</h5>
                <form action="<?= base_url('admin/produk/add') ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                    <?= csrf_field() ?> <!-- CSRF protection -->

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Produk</label>
                        <select class="form-control" name="kategori" id="kategori" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <!-- Loop kategori di sini -->
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Varian Produk (Ukuran, Harga, Stok) -->
                    <div id="variant-wrapper">
                        <div class="variant-item row mb-3">
                            <div class="col-md-3">
                                <label for="size[]" class="form-label">Ukuran</label>
                                <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" required>
                            </div>
                            <div class="col-md-3">
                                <label for="price[]" class="form-label">Warna</label>
                                <input type="text" class="form-control" name="color[]" placeholder="Warna" required>
                            </div>
                            <div class="col-md-3">
                                <label for="price[]" class="form-label">Harga</label>
                                <input type="number" class="form-control" name="price[]" placeholder="Harga" required>
                            </div>
                            <div class="col-md-3">
                                <label for="stock[]" class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stock[]" placeholder="Stok" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="add-variant-btn">Tambah Varian</button>

                    <!-- Upload Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Gambar Produk</label>
                        <input type="file" class="form-control" name="images[]" id="image" multiple required>
                    </div>
                    <div id="image-preview" class="d-flex flex-wrap gap-2 mb-2"></div>

                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
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
    // Script untuk menambah varian secara dinamis
    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const variantWrapper = document.getElementById('variant-wrapper');

        const newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'row', 'mb-3');

        newVariant.innerHTML = `
            <div class="col-md-3">
                <label for="size[]" class="form-label">Ukuran</label>
                <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" required>
            </div>
            <div class="col-md-3">
                <label for="color[]" class="form-label">Warna</label>
                <input type="text" class="form-control" name="color[]" placeholder="Warna" required>
            </div>
            <div class="col-md-3">
                <label for="price[]" class="form-label">Harga</label>
                <input type="number" class="form-control" name="price[]" placeholder="Harga" required>
            </div>
            <div class="col-md-3">
                <label for="stock[]" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stock[]" placeholder="Stok" required>
            </div>
        `;
        variantWrapper.appendChild(newVariant);
    });

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
</script>
<?= $this->endSection(); ?>