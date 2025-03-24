<?php
include 'koneksi.php';

$id = $_GET['id'];
$sql = "SELECT * FROM transaksi WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];

    $sql_update = "UPDATE transaksi SET nama_barang='$nama_barang', jumlah='$jumlah', harga='$harga' WHERE id='$id'";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi</title>
</head>
<body>
    <h2>Edit Transaksi</h2>
    <form action="" method="POST">
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required><br><br>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="<?php echo $row['jumlah']; ?>" required><br><br>

        <label>Harga:</label>
        <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="dashboard.php">Batal</a>
    </form>
</body>
</html>
