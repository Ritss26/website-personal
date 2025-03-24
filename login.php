<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username']; // Simpan username dalam session
        header("Location: index.php");
        exit();
    } else {
        echo "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('bengkel.png');
        }
        .container {
            width: 360px;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            
        }
        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
            font-size: 28px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background:rgb(214, 0, 0);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background:rgb(255, 0, 0);
        }
        p {
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
        }
        a {
            color:rgb(243, 0, 0);
            text-decoration: none;
            font-weight: bold;
        }
        .error {
            background: #ffe6e6;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            color: #ff4d4d;
            font-size: 14px;
            text-align: center;
            font-weight: bold;
        }
        .login-form img {
         width: 300px;
         height: 100px;
         margin-bottom: 10px;
         
        }
        .login-form h2 {
        margin-bottom: 20px;
        font-size: 26px;
        }


    </style>
</head>
<body>
<div class="container">
    <form method="POST">
   <div class="login-form"> <img src="2.jpg" alt="Logo RPM Motor"></div>
        <h2>Login</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </form>
</div>
</body>
</html>
