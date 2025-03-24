<?php
require('fpdf/fpdf.php'); // Pastikan FPDF sudah ada
include 'koneksi.php';

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Ambil data transaksi berdasarkan tanggal
$query = "SELECT * FROM transaksi WHERE tanggal = '$tanggal'";
$result = $conn->query($query);

// Hitung total pendapatan harian
$queryTotal = "SELECT SUM(harga * jumlah) AS total_pendapatan FROM transaksi WHERE tanggal = '$tanggal'";
$totalResult = $conn->query($queryTotal);
$rowTotal = $totalResult->fetch_assoc();
$totalPendapatan = $rowTotal['total_pendapatan'] ?? 0;

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Judul Laporan (Rata Tengah)
$pdf->Cell(190, 10, "Laporan Transaksi Bengkel RPM Tanggal: " . $tanggal, 0, 1, 'C');
$pdf->Ln(5);

// Posisi Awal (Supaya Tabel Rata Tengah)
$marginKiri = 20;
$pdf->SetX($marginKiri);

// Header tabel (Lebar total 170 agar pas tengah)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumlah', 1, 0, 'C');
$pdf->Cell(40, 10, 'Harga Satuan', 1, 0, 'C');
$pdf->Cell(50, 10, 'Total', 1, 1, 'C');

// Isi Data Tabel (Tetap Rata Tengah)
$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $totalHarga = $row['harga'] * $row['jumlah'];
    $pdf->SetX($marginKiri);
    $pdf->Cell(50, 10, $row['nama_barang'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['jumlah'], 1, 0, 'C');
    $pdf->Cell(40, 10, 'Rp ' . number_format($row['harga'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(50, 10, 'Rp ' . number_format($totalHarga, 0, ',', '.'), 1, 1, 'R');
}

// Spasi sebelum total
$pdf->Ln(5);

// Total Pendapatan Harian (Rata Tengah)
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX($marginKiri);
$pdf->Cell(170, 10, 'Total Pendapatan Hari Ini: Rp ' . number_format($totalPendapatan, 0, ',', '.'), 1, 1, 'C');

$pdf->Output();
?>
