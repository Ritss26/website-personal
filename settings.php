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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $nama = $_POST['nama'];
        
        $sql = "UPDATE users SET nama = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nama, $username);
        if ($stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui!');</script>";
        }
    }
    
    if (isset($_POST['update_password'])) {
        $password_lama = $_POST['password_lama'];
        $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);

        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (password_verify($password_lama, $row['password'])) {
            $sql = "UPDATE users SET password = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password_baru, $username);
            if ($stmt->execute()) {
                echo "<script>alert('Password berhasil diperbarui!');</script>";
            }
        } else {
            echo "<script>alert('Password lama salah!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 500px; margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { font-weight: bold; display: block; }
        input[type='text'], input[type='password'] { width: 100%; padding: 8px; }
        button { background: #28a745; color: white; padding: 8px 12px; border: none; cursor: pointer; }
        button:hover { background: #218838; }

    .btn-back {
    background: #6c757d;
    color: white;
    padding: 8px 12px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 10px;
}

.btn-back:hover {
    background: #5a6268;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Pengaturan</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            </div>
            <button type="submit" name="update_profile">Update Profil</button>
        </form>
       
    </div>
    <a href="dashboard.php" class="btn btn-back">⬅ Kembali</a>

</body>
</html>