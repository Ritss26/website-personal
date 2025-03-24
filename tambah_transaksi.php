<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $tanggal = date('Y-m-d');

    $tanggal_hari_ini = date('Y-m-d'); // Ambil tanggal hari ini
    $sql = "INSERT INTO transaksi (nama_barang, jumlah, harga, tanggal) VALUES ('$nama_barang', '$jumlah', '$harga', '$tanggal_hari_ini')";

    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
</head>
<style>
   /* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Body Styling */
.body-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: #f8f9fa; /* Warna latar putih lembut */
}

/* Form Container */
.form-container {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: 350px;
    text-align: center;
    border-top: 5px solid #dc3545; /* Garis atas merah */
}

/* Title */
.form-title {
    margin-bottom: 20px;
    color:rgb(133, 0, 13); /* Warna merah */
    font-size: 22px;
    font-weight: bold;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
    text-align: left;
}

/* Label */
.label {
    font-weight: bold;
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
    color:rgb(143, 0, 14); /* Warna merah */
}

/* Input Field */
.input-field {
    width: 100%;
    padding: 10px;
    border: 2px solid #ffcc00; /* Warna kuning */
    border-radius: 5px;
    font-size: 14px;
    background: #fff5cc; /* Latar belakang kuning muda */
    transition: all 0.3s ease-in-out;
}

.input-field:focus {
    border-color:rgb(129, 0, 13); /* Warna merah saat fokus */
    outline: none;
    box-shadow: 0px 0px 5px rgba(220, 53, 69, 0.5);
}

/* Button Container */
.button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

/* Button Styling */
.btn {
    padding: 10px 15px;
    font-size: 14px;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    width: 48%;
    border: none;
    font-weight: bold;
}

/* Submit Button */
.btn-submit {
    background:rgb(150, 0, 15); /* Merah */
    color: white;
}

.btn-submit:hover {
    background:rgb(165, 0, 19); /* Merah gelap */
}

/* Cancel Button */
.btn-cancel {
    background: #ffcc00; /* Kuning */
    color: #333; /* Warna teks hitam */
}

.btn-cancel:hover {
    background: #e6b800; /* Kuning gelap */
}

</style>
<body class="body-container">
    <div class="form-container">
        <h2 class="form-title">Tambah Transaksi</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label class="label">Nama Barang:</label>
                <input type="text" name="nama_barang" class="input-field" required>
            </div>

            <div class="form-group">
                <label class="label">Jumlah:</label>
                <input type="number" name="jumlah" class="input-field" required>
            </div>

            <div class="form-group">
                <label class="label">Harga:</label>
                <input type="number" name="harga" class="input-field" required>
            </div>

            <div class="button-container">
                <input type="submit" value="Tambah" class="btn btn-submit">
                <a href="dashboard.php" class="btn btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
