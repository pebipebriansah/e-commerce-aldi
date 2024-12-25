<!-- use template -->
<?= $this->extend('admin/template'); ?>

<?= $this->section('header'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- sweet alert -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php elseif (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>',
        })
    </script>
<?php endif ?>
<!--  Row 1 -->
<div class="row" id="app">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title fw-semibold">Laporan</h5>
                </div>
                <!-- date filter jquery -->
                <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                    <div class="input-group">
                        <div class="d-flex flex-column me-2">
                            <label for="start_date" class="form-label fw-semibold">Tanggal Awal</label>
                            <input type="date" class="form-control" id="min" name="min" placeholder="Tanggal Awal">
                        </div>
                        <div class="d-flex flex-column me-2">
                            <label for="end_date" class="form-label fw-semibold">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="max" name="max" placeholder="Tanggal Akhir">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped text-nowrap mb-0 align-middle" id="myTable">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Tanggal</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Nama Customer</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Produk</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Qty</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Harga</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['order_date'] ?>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['user_name'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 "><?= $item['product_name'] . ' | ' . $item['size'] . ' | ' . $item['color'] ?></h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success rounded-3 fw-semibold"><?= $item['quantity'] ?></span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success rounded-3 fw-semibold">Rp. <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                                        </div>
                                    </td>
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-success rounded-3 fw-semibold"><?= $item['status'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script>
    $(document).ready(function() {

        let table;

        DataTable.ext.search.push(function(settings, data, dataIndex) {
            // Ambil nilai dari input tanggal
            let min = $('#min').val();
            let max = $('#max').val();

            // simpan ke minDate dan maxDate
            console.log(min, max);
            // Ambil tanggal dari kolom pertama tabel
            let rowDateStr = data[0]; // Kolom tanggal
            let rowDate = new Date(rowDateStr.split(' ')[0]); // Ambil hanya tanggal

            // Konversi nilai input menjadi objek Date
            let minDate = min ? new Date(min) : null;
            let maxDate = max ? new Date(max) : null;

            // Filter data berdasarkan range
            if (
                (!minDate || rowDate >= minDate) &&
                (!maxDate || rowDate <= maxDate)
            ) {
                return true;
            }
            return false;
        });


        table = $('#myTable').DataTable({
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Laporan Transaksi'

                },
                {
                    extend: 'pdfHtml5',
                    footer: true,
                    title: 'Laporan Transaksi',
                    customize: function(doc) {

                        doc.content.splice(1, 0, {
                            text: 'Toko AyHijab',
                            alignment: 'center',
                            fontSize: 14,
                            bold: true,
                            margin: [0, 0, 0, 10]
                        });
                        doc.content.splice(2, 0, {
                            text: 'Ciawi - Kuningan Jawa Barat',
                            alignment: 'center',
                            fontSize: 12,
                            bold: true,
                            margin: [0, 0, 0, 10]
                        });
                        doc.content[3].alignment = 'left'; // Rata kiri
                        doc.content[3].fontSize = 10; // Ukuran font 10
                        doc.content[3].margin = [0, 10, 0, 10]; // Margin untuk title
                    }

                }
            ],
            order: [
                [0, 'desc']
            ],
        });

        function totalHarga() {
            let total = 0;
            let totalData = table.rows({
                search: 'applied'
            }).nodes(); // Ambil semua baris yang difilter
            let currentPageData = table.rows({
                search: 'applied',
                page: 'current'
            }).nodes(); // Ambil baris di halaman saat ini

            // Debug: Tampilkan data yang diambil dari halaman saat ini

            $(currentPageData).each(function() {
                let value = $(this).find('td:eq(3)').text(); // Ambil data dari kolom ke-4 (Total Rp)
                let parsedValue = parseInt(value.replace(/\./g, ''), 10); // Parsing value

                total += isNaN(parsedValue) ? 0 : parsedValue; // Tambahkan nilai ke total
            });

            // Format total ke dalam format mata uang IDR
            $('#total').html(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total));

        }


        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', function() {
                table.draw();
                totalHarga();
            });
        });

        // tambahkan kode pada saat search data menampilkam total harga
        table.on('search.dt', function() {
            totalHarga();
        });

        totalHarga();
        // Move the buttons container to the dataTables_filter container
        table.buttons().container().appendTo($('#myTable_wrapper .dataTables_filter'));

        table.on('draw.dt', function() {
            totalHarga(); // Panggil ulang totalHarga setelah halaman berubah
        });
    });
</script>
<?= $this->endSection(); ?>