<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
  

    // Cek apakah username sudah ada
    $cekUsername = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($cekUsername);

    if ($result->num_rows > 0) {
        echo "Username sudah digunakan!";
    } else {
        // Upload foto jika ada
        $foto = "default.jpg"; // Default foto jika tidak diupload
        if (!empty($_FILES["foto"]["name"])) {
            $targetDir = "uploads/";
            $foto = basename($_FILES["foto"]["name"]);
            $targetFilePath = $targetDir . $foto;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath);
        }

        // Simpan data user baru
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi berhasil! <a href='login.php'>Login</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { height: 100vh; display: flex; justify-content: center; align-items: center; background: #f0f4f8; }
        .container { width: 360px; padding: 30px; background: #fff; border-radius: 12px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 24px; color: #333; font-size: 28px; }
        input { width: 100%; padding: 12px; margin-bottom: 18px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; }
        button { width: 100%; padding: 12px; background:rgb(172, 0, 0); color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        button:hover { background:rgb(165, 0, 0); }
        p { text-align: center; margin-top: 16px; font-size: 14px; }
        a { color:rgb(143, 0, 0); text-decoration: none; font-weight: bold; }
        .error { background: #ffe6e6; padding: 10px; margin-bottom: 15px; border-radius: 6px; color: #ff4d4d; font-size: 14px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <form method="POST">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Daftar</button>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
</div>
</body>
</html>
