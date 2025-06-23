<?php
session_start();
include 'koneksidb.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id_user, nama, password, status FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['status'] = $user['status'];

            if ($user['status'] == 'Admin'){
                header("Location: dashboard.php");
                exit;
            } elseif ($user['status'] == 'Pelanggan'){
                header("Location: index.php");
                exit;
            }
        } else {
            $error_message = "Password yang Anda masukkan salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HotelPedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f2f4f8; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .login-container { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
        }
        .login-container h1 { 
            color: #4e54c8; 
            margin-bottom: 10px; 
        }
        .login-container p { 
            color: #777; 
            margin-bottom: 30px; 
        }
        .form-group { 
            margin-bottom: 20px; 
            text-align: left; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: 500; 
        }
        .form-group input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ccc; 
            border-radius: 8px; 
            box-sizing: border-box; 
        }
        .btn { 
            width: 100%; 
            padding: 12px; 
            border: none; 
            border-radius: 8px; 
            background: linear-gradient(45deg, #4e54c8, #8f94fb); 
            color: white; 
            font-size: 1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 
            opacity 0.3s ease; 
        }
        .btn:hover { 
            opacity: 0.9; 
        }
        .error-msg { 
            background-color: #f8d7da; 
            color: #721c24; 
            padding: 10px; 
            border-radius: 8px; m
            argin-bottom: 20px; 
            border: 1px solid #f5c6cb; 
        }
        .register-link { 
            margin-top: 20px; 
            font-size: 0.9rem; 
        }
        .register-link a { 
            color: #4e54c8; 
            text-decoration: none; 
            font-weight: 600; 
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Selamat Datang Kembali</h1>
        <p>Silakan login untuk melanjutkan reservasi.</p>

        <?php if (!empty($error_message)): ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>