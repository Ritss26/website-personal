<?php
include 'koneksi.php';

$id = $_GET['id'];

$sql = "DELETE FROM transaksi WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard.php';</script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
