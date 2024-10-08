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
                            <div class="col-md-4">
                                <label for="size[]" class="form-label">Ukuran</label>
                                <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" required>
                            </div>
                            <div class="col-md-4">
                                <label for="price[]" class="form-label">Harga</label>
                                <input type="number" class="form-control" name="price[]" placeholder="Harga" required>
                            </div>
                            <div class="col-md-4">
                                <label for="stock[]" class="form-label">Stok</label>
                                <input type="number" class="form-control" name="stock[]" placeholder="Stok" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="add-variant-btn">Tambah Varian</button>

                    <!-- Upload Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Gambar Produk</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<!-- Script untuk menambah varian secara dinamis -->
<script>
    document.getElementById('add-variant-btn').addEventListener('click', function() {
        const variantWrapper = document.getElementById('variant-wrapper');

        const newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'row', 'mb-3');

        newVariant.innerHTML = `
            <div class="col-md-4">
                <label for="size[]" class="form-label">Ukuran</label>
                <input type="text" class="form-control" name="size[]" placeholder="Contoh: S, M, L" required>
            </div>
            <div class="col-md-4">
                <label for="price[]" class="form-label">Harga</label>
                <input type="number" class="form-control" name="price[]" placeholder="Harga" required>
            </div>
            <div class="col-md-4">
                <label for="stock[]" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stock[]" placeholder="Stok" required>
            </div>
        `;

        variantWrapper.appendChild(newVariant);
    });
</script>
<?= $this->endSection(); ?>