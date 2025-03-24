<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Ambil data user dari database
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #343a40;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 6px 0;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #495057;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Header */
        .header {
            background: rgb(177, 0, 0);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 22px;
        }

        /* Content */
        .content {
            padding: 20px;
        }

        .container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            align-items: center;
        }
        .con{
            padding: 6px 10px;
            border-radius: 4px;
            color: yellow;
            text-decoration: none;
            margin: 10px 0; /* Memberi jarak atas dan bawah */
            background: rgb(150, 0, 0);
            display: flex;         /* Menggunakan Flexbox */
            justify-content: center; /* Pusatkan horizontal */
            align-items: center;   /* Pusatkan vertikal */
            text-align: center;    /* Untuk memastikan teks dalam elemen inline juga di tengah */
            width: fit-content;    /* Sesuaikan ukuran dengan teks (opsional) */
        }
        .box {
            width: 200px;
            height: 100px;
            background:rgb(126, 0, 0);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .box a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .box:hover {
            background:rgb(172, 11, 0);
        }

        /* Tabel Transaksi */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background:rgb(148, 0, 0);
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Tombol Aksi */
        .btn {
            padding: 6px 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            margin: 0 2px;
            font-size: 14px;
        }

        .btn-add {
            background: #28a745;
        }

        .btn-edit {
            background: #ffc107;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }
        .filter-container {
         display: flex;
         justify-content: flex-end; /* Pindahkan ke kanan */
         margin-bottom: 10px; /* Beri jarak ke bawah */
        }

.header-container {
    display: flex;
    justify-content: space-between; /* Membuat kedua elemen berada di kiri dan kanan */
    align-items: center; /* Agar teks dan form tetap sejajar */
    margin-bottom: 10px; /* Beri sedikit jarak ke bawah */
    gap: 10px;
}

.filter-container {
    display: flex;
    gap: 10px; /* Beri jarak antara input dan tombol */
    align-items: center; /* Pastikan elemen di dalamnya sejajar */
}

.filter-container button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.filter-container button:hover {
    background-color: #218838;
}



        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 10px;
                align-items: center;
            }

            .sidebar h2 {
                display: none;
            }

            .sidebar a {
                text-align: center;
                padding: 10px;
            }

            .header h1 {
                font-size: 18px;
            }

            .box {
                width: 150px;
                height: 80px;
                font-size: 14px;
            }
        }

        .login-form img {
            width: 180px;
            height: 100px;
            margin-bottom: 10px;
        }
        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white; /* Border putih agar lebih estetik */
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.5); /* Efek bayangan lembut */
        }

        .welcome-text {
            font-size: 18px;
            font-weight: bold;
            white-space: nowrap; /* Mencegah teks pindah baris */
        }
/* Pagination Container */
.pagination {
    text-align: center;
    margin-top: 20px;
}

/* Pagination Links */
.pagination a {
    display: inline-block;
    padding: 8px 12px;
    margin: 3px;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    color:rgb(165, 0, 16); /* Warna merah */
    background: #fff;
    border: 2px solid #dc3545; /* Border merah */
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
}

/* Hover Effect */
.pagination a:hover {
    background:rgb(170, 0, 17); /* Warna merah saat hover */
    color: white;
}

/* Active Page */
.pagination a.active {
    background:rgb(134, 0, 13); /* Warna merah untuk halaman aktif */
    color: white;
    border: 2px solidrgb(138, 0, 16); /* Warna merah gelap */
    pointer-events: none;
}

/* Next & Prev Buttons */
.pagination a:first-child,
.pagination a:last-child {
    font-size: 16px;
    padding: 10px 14px;
    font-weight: bold;
}

/* Responsive */
@media screen and (max-width: 600px) {
    .pagination a {
        padding: 6px 10px;
        font-size: 12px;
    }
}



    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="login-form"><img src="2.jpg" alt="Logo RPM Motor"></div>
        <h2>Menu</h2>
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="profile.php">👤 Profile</a>
        <a href="settings.php">⚙️ Pengaturan</a>
        <a href="logout.php" onclick="return confirm('Yakin mau logout?')">🚪 Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="header-container">
                <img class="profile-img" src="uploads/<?php echo htmlspecialchars($user['foto'] ?? 'default.png'); ?>" alt="Foto Profil">
                <span class="welcome-text"><h3>Selamat Datang, </h3>  <?php echo htmlspecialchars($user['nama']); ?>!</span>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
    <div class="header-container">
        <div class="con"><h2>DATA HARI INI, BENGKEL RPM MOTOR</h2></div>
        <div class="filter-container">
            <form method="GET" action="">
                <label for="tanggal">Pilih Tanggal:</label>
                <input type="date" name="tanggal" value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d'); ?>">
                <button type="submit">Cari</button>
            </form>
        </div>
    </div>


            <div class="container">
                <!-- Tombol Tambah -->
            <a href="tambah_transaksi.php" class="btn btn-add">+ Tambah Transaksi</a>

            </div>
            <form action="cetak_pdf.php" method="GET" style="margin-bottom: 10px;">
            <label for="tanggal">Pilih Tanggal:</label>
            <input type="date" name="tanggal" required>
            <button type="submit" class="btn btn-add">Cetak PDF</button>
             </form>

            <!-- Tabel Transaksi -->
            <table>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php
                include 'koneksi.php';

                $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
                
                // Tentukan jumlah data per halaman
                $limit = 10; // Ubah sesuai kebutuhan
                
                // Ambil total data
                $sqlCount = "SELECT COUNT(*) AS total FROM transaksi WHERE tanggal = '$tanggal'";
                $resultCount = $conn->query($sqlCount);
                $rowCount = $resultCount->fetch_assoc();
                $totalData = $rowCount['total'];
                
                // Hitung jumlah halaman
                $totalPages = ceil($totalData / $limit);
                
                // Tentukan halaman saat ini
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $limit;
                
                // Query untuk mengambil data dengan limit
                $sql = "SELECT * FROM transaksi WHERE tanggal = '$tanggal' LIMIT $start, $limit";
                $result = $conn->query($sql);
                
                if (!$result){
                    die("Query gagal: " . $conn->error);
                }
                $no =1;
                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
                        echo "<tr>
                        <td>" . $no++ . "</td>
                         <td>" . $row['nama_barang'] . "</td>
                          <td>" . $row['jumlah'] . "</td>
                           <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                           <td>" . $row['tanggal'] . "</td>
               <td>
                <a href='edit_transaksi.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a>
                <a href='hapus_transaksi.php?id=" . $row['id'] . "' class='btn btn-delete' onclick=\"return confirm('Yakin ingin menghapus?');\">Hapus</a>
                </td>

                </tr>";
                    }
                }else{
                    echo "<tr><td colspan='6'>Tidak Ada Data</td></tr>";
                }
                $conn->close();
            ?>
         
            </div>
        </table>
        <!-- Navigasi Pagination -->
<div class="pagination">
    <?php
    if ($totalPages > 1) {
        if ($page > 1) {
            echo "<a href='?tanggal=$tanggal&page=" . ($page - 1) . "'>❮ Back</a>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<a href='?tanggal=$tanggal&page=$i' class='active'>$i</a>";
            } else {
                echo "<a href='?tanggal=$tanggal&page=$i'>$i</a>";
            }
        }

        if ($page < $totalPages) {
            echo "<a href='?tanggal=$tanggal&page=" . ($page + 1) . "'>Next ❯</a>";
        }
    }
    ?>
</div>


</body>
</html>
