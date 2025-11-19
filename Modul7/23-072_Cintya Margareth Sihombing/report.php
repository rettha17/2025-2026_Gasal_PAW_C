<?php
$conn = mysqli_connect("localhost", "root", "", "report_db");

$start = $_GET['start'] ?? null;
$end   = $_GET['end'] ?? null;

$tanggal = [];
$pendapatan = [];
$data = [];

if ($start && $end) {
    $q = mysqli_query($conn, "
        SELECT * FROM transaksi
        WHERE tanggal BETWEEN '$start' AND '$end'
        ORDER BY tanggal ASC
    ");

    while ($r = mysqli_fetch_assoc($q)) {
        $tanggal[]    = $r['tanggal'];
        $pendapatan[] = $r['total'];
        $data[]       = $r;
    }

    $total_pelanggan = count($data);
    $total_pendapatan = array_sum($pendapatan);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial;
        }

        .chart-box {
            width: 800px;
            margin: auto;
        }

        table {
            border-collapse: collapse;
            width: 800px;
            margin: auto;
        }

        table, th, td {
            border: 1px solid #bcd;
            padding: 8px;
        }

        th {
            background: #d8eef5;
            text-align: center;
        }

        .total-box {
            width: 800px;
            margin: auto;
            border: 1px solid #bcd;
            background: #f5f7f8;
        }
        
        .total-box th {
            background: #d8eef5;
            padding: 12px;
        }
        
        .total-box td {
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Laporan Transaksi</h2>

<form method="GET" class="no-print" style="text-align:center;">
    <label>Dari Tanggal:</label>
    <input type="date" name="start" value="<?= $start ?>" required>

    <label>Sampai Tanggal:</label>
    <input type="date" name="end" value="<?= $end ?>" required>

    <button type="submit">Cari</button>
</form>

<hr>

<?php if ($start && $end) { ?>

<div class="chart-box">
    <h3>Grafik Pendapatan</h3>
    <canvas id="chart" height="150"></canvas>
</div>

<script>
let labels = <?= json_encode($tanggal) ?>;
let values = <?= json_encode($pendapatan) ?>;

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: "Total",
            data: values,
            backgroundColor: "#d0e7ff",
            borderColor: "#7bb0f0",
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<br><hr>

<h3 style="width:800px; margin:auto;">Rekap Transaksi</h3>

<table>
    <tr>
        <th>No</th>
        <th>Total</th>
        <th>Tanggal</th>
    </tr>

<?php 
$no = 1;
foreach ($data as $d) { ?>
    <tr>
        <td style="text-align:center;"><?= $no++ ?></td>
        <td>RP. <?= number_format($d['total'],0,',','.') ?></td>
        <td><?= date("d M Y", strtotime($d['tanggal'])) ?></td>
    </tr>
<?php } ?>
</table>

<br><hr>

<h3 style="width:800px; margin:auto;">Total</h3>

<table class="total-box">
    <tr>
        <th>Jumlah Pelanggan</th>
        <th>Jumlah Pendapatan</th>
    </tr>
    <tr>
        <td style="text-align:center;"><?= $total_pelanggan ?> Orang</td>
        <td style="text-align:center;">RP. <?= number_format($total_pendapatan,0,',','.') ?></td>
    </tr>
</table>

<br>

<div class="no-print" style="width:800px; margin:auto;">
    <button onclick="window.print()">PRINT</button>

    <a href="export_excel.php?start=<?= $start ?>&end=<?= $end ?>">
        <button>EXCEL</button>
    </a>
</div>

<?php } ?>

</body>
</html>
