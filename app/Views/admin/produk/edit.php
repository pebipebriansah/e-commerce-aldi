<?= $this->extend('admin/template'); ?>
<?= $this->section('content'); ?>

<div class="row" id="app">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold">Edit Produk</h5>
                <form action="<?= site_url('admin/produk/update') ?>" method="post" enctype="multipart/form-data" class="mt-3">

                    <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" value="<?= $product['name'] ?>" name="name" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="12" required><?= $product['description'] ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Produk</label>
                        <select class="form-control" name="kategori" id="kategori" required>
                            <option value="" disabled>Pilih Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Varian Produk (Ukuran, Harga, Stok) -->
                    <div id="variant-wrapper">
                        <?php foreach ($product['size'] as $size) : ?>
                            <div class="variant-item row mb-3">
                                <div class="col-md-2">
                                    <label for="size[]" class="form-label">Ukuran</label>
                                    <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" value="<?= $size['size'] ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="warna[]" class="form-label">Warna</label>
                                    <input type="text" class="form-control" name="color[]" placeholder="Warna" value="<?= $size['color'] ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="price[]" class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="price[]" placeholder="Harga" value="<?= $size['price'] ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="price[]" class="form-label">Diskon (%)</label>
                                    <input type="number" class="form-control" name="discount[]" placeholder="Harga" value="<?= $size['discount'] ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="stock[]" class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stock[]" placeholder="Stok" value="<?= $size['stock'] ?>" required>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-variant-btn">Hapus</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-variant-btn" class="btn btn-primary">Tambah Varian</button>

                    <div class="mb-3">
                        <!-- Tampilkan Gambar yang Sudah Ada -->
                        <label for="current-images" class="form-label mt-3">Gambar Saat Ini</label>
                        <div id="current-images" class="d-flex flex-wrap gap-3">
                            <?php foreach ($product['image'] as $img): ?>
                                <div class="image-preview-container" data-id="<?= $img['id'] ?>">
                                    <img src="<?= base_url('produk/' . $img['image']) ?>" alt="Gambar Produk">
                                    <button type="button" class="remove-image" onclick="removeExistingImage(<?= $img['id'] ?>)">×</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Upload Gambar Baru -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Tambah Gambar Baru</label>
                        <input type="file" class="form-control" name="images[]" id="image" multiple>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const variantWrapper = document.getElementById('variant-wrapper');
        const newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'row', 'mb-3');

        newVariant.innerHTML = `
        <div class="col-md-2">
            <label for="size[]" class="form-label">Ukuran</label>
            <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" required>
        </div>
        <div class="col-md-3">
            <label for="warna[]" class="form-label">Warna</label>
            <input type="text" class="form-control" name="color[]" placeholder="Warna" required>
        </div>
        <div class="col-md-2">
            <label for="price[]" class="form-label">Harga</label>
            <input type="number" class="form-control" name="price[]" placeholder="Harga" required>
        </div>
        <div class="col-md-2">
            <label for="price[]" class="form-label">Diskon (%)</label>
            <input type="number" class="form-control" name="discount[]" placeholder="Diskon" required>
        </div>
        <div class="col-md-2">
            <label for="stock[]" class="form-label">Stok</label>
            <input type="number" class="form-control" name="stock[]" placeholder="Stok" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-variant-btn">Hapus</button>
        </div>
    `;

        variantWrapper.appendChild(newVariant);
        attachRemoveVariantListener(newVariant.querySelector('.remove-variant-btn'));
    });

    function attachRemoveVariantListener(button) {
        button.addEventListener('click', function() {
            button.closest('.variant-item').remove();
        });
    }

    // Attach remove listener to existing variants
    document.querySelectorAll('.remove-variant-btn').forEach(button => {
        attachRemoveVariantListener(button);
    });

    // Array untuk menyimpan ID gambar yang akan dihapus
    let imagesToDelete = [];

    function removeExistingImage(imageId) {
        // Tambahkan ID gambar ke array imagesToDelete
        imagesToDelete.push(imageId);

        // Hapus elemen dari tampilan
        document.querySelector(`#current-images [data-id="${imageId}"]`).remove();
    }

    // Tambahkan array imagesToDelete ke dalam form saat disubmit
    document.querySelector('form').addEventListener('submit', function(event) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'images_to_delete';
        input.value = JSON.stringify(imagesToDelete);
        this.appendChild(input);
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