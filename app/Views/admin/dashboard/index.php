<!-- use template -->
<?= $this->extend('admin/template'); ?>


<?= $this->section('content'); ?>
<!-- sweet alert -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php endif ?>
<!--  Row 1 -->
<div class="row">
    <div class="col-lg-8 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Grafik Penjualan</h5>
                    </div>
                    <div>
                        <!-- data month -->
                        <select class="form-select" name="month" id="filter-date" onchange="window.location.href=this.value;">
                            <?php foreach ($months as $month): ?>
                                <option value="<?= base_url('/admin/dashboard?value=' . $month['value']); ?>" <?= $dateFilter == $month['value'] ? 'selected' : '' ?>>
                                    <?= $month['text']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div id="chartPenjualan"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Pendapatan Bulan Ini</h5>
                        <div class="row align-items-center">
                            <div class="col-8">
                                <?php
                                $total = 0;
                                foreach ($grafik as $item) {
                                    $total += $item['total'];
                                } ?>
                                <h4 class="fw-semibold mb-3">Rp. <?= number_format($total ?? 0, 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$categories = [];
$jumlahOrder = [];

foreach ($grafik as $row) {
    $categories[] = $row['date']; // Tanggal untuk kategori
    $jumlahOrder[] = $row['jumlah_order']; // Jumlah order untuk data chart
}
?>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var chart = {
        series: [{
            name: "Total Penjualan:",
            data: <?= json_encode($jumlahOrder); ?>
        }],

        chart: {
            type: "bar",
            height: 345,
            offsetX: -15,
            toolbar: {
                show: true
            },
            foreColor: "#adb0bb",
            fontFamily: 'inherit',
            sparkline: {
                enabled: false
            },
        },

        colors: ["#5D87FF"],

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "35%",
                borderRadius: [6],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        markers: {
            size: 0
        },

        dataLabels: {
            enabled: false,
        },

        legend: {
            show: false,
        },

        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },

        xaxis: {
            type: "category",
            categories: <?= json_encode($categories); ?>, // Tanggal sebagai kategori
            labels: {
                style: {
                    cssClass: "grey--text lighten-2--text fill-color"
                },
            },
        },

        yaxis: {
            show: true,
            min: 0,
            max: Math.max(...<?= json_encode($jumlahOrder); ?>), // Menyesuaikan skala y-axis
            tickAmount: 4,
            labels: {
                style: {
                    cssClass: "grey--text lighten-2--text fill-color",
                },
            },
        },
        stroke: {
            show: true,
            width: 3,
            lineCap: "butt",
            colors: ["transparent"],
        },

        tooltip: {
            theme: "light"
        },

        responsive: [{
            breakpoint: 600,
            options: {
                plotOptions: {
                    bar: {
                        borderRadius: 3,
                    }
                },
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chartPenjualan"), chart);
    chart.render();
</script>

<?= $this->endSection(); ?>