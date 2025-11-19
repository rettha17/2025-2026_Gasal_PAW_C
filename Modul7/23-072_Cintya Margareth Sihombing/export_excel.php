<?php
$conn = mysqli_connect("localhost","root","","report_db");

$start = $_GET['start'];
$end   = $_GET['end'];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_$start-$end.xls");

// QUERY
$q = mysqli_query($conn, "
    SELECT * FROM transaksi
    WHERE tanggal BETWEEN '$start' AND '$end'
    ORDER BY tanggal ASC
");

// SIAPKAN TOTAL
$data = [];
$total_pendapatan = 0;

while($r = mysqli_fetch_assoc($q)){
    $data[] = $r;
    $total_pendapatan += $r['total'];
}

$total_pelanggan = count($data);

// ========================
// OUTPUT EXCEL
// ========================

echo "
<h3 style='font-weight:bold;'>Rekap Laporan Penjualan ($start s/d $end)</h3>

<table border='1' cellpadding='6' cellspacing='0'>
    <tr>
        <th>No</th>
        <th>Total</th>
        <th>Tanggal</th>
    </tr>
";

$no = 1;
foreach($data as $d){
    echo "
    <tr>
        <td>$no</td>
        <td>RP. " . number_format($d['total'],0,',','.') . "</td>
        <td>" . date("d M Y", strtotime($d['tanggal'])) . "</td>
    </tr>";
    $no++;
}

echo "</table>";

echo "
<br>

<table border='0' cellpadding='6'>
    <tr>
        <td><b>Jumlah Pelanggan</b></td>
        <td><b>Jumlah Pendapatan</b></td>
    </tr>
    <tr>
        <td>". $total_pelanggan ." Orang</td>
        <td>RP. ". number_format($total_pendapatan,0,',','.') ."</td>
    </tr>
</table>
";
?>
