<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8');

    // Cek apakah ada file foto yang diupload
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";

        // Buat folder jika belum ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $foto_name = time() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
        
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }
        

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $sqlUpdate = "UPDATE users SET nama=?, foto=? WHERE username=?";
                $stmt = $conn->prepare($sqlUpdate);
                $stmt->bind_param("sss", $nama, $foto_name, $username);
            } else {
                echo "Gagal mengupload foto.";
                exit();
            }
        } else {
            echo "Format file tidak diizinkan. Gunakan JPG, JPEG, PNG, atau GIF.";
            exit();
        }
    } else {
        $sqlUpdate = "UPDATE users SET nama=? WHERE username=?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("ss", $nama, $username);
    }

    if ($stmt->execute()) {
        header("Location: profile.php");
        exit();
    } else {
        echo "Gagal memperbarui profil. Error: " . $stmt->error;
    }
}
?>

<<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        .container { width: 50%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; }
        input, button { padding: 10px; margin: 5px; width: 100%; }
        .btn-save { background: green; color: white; border: none; cursor: pointer; }
        .btn-save:hover { background: darkgreen; }
        .btn-back { background: gray; color: white; border: none; cursor: pointer; }
        .btn-back:hover { background: darkgray; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profil Saya</h2>
        <img src="uploads/<?php echo htmlspecialchars($user['foto'] ?? 'default.png'); ?>" alt="Foto Profil"><br><br>

        <form method="POST" enctype="multipart/form-data">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

            <label>Foto Profil:</label>
            <input type="file" name="foto" accept="image/*">
            
            <button type="submit" class="btn-save">Simpan Perubahan</button>
        </form>

        <button class="btn-back" onclick="window.history.back();">Kembali</button>
    </div>
</body>
</html>