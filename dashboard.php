<?php
session_start();
include 'koneksidb.php';

// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

$kamar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_kamar FROM kamar"));
$reservasi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_reservasi FROM reservasi"));
// $user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_user FROM user"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin | Hotel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f2f4f8;
    }

    .navbar {
      background: linear-gradient(45deg, #4e54c8, #8f94fb);
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar h2 {
      margin: 0;
      font-weight: 600;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    .container {
      padding: 30px;
    }

    .card-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .card {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
      transition: 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      margin: 0;
      color: #4e54c8;
    }

    .card p {
      margin-top: 10px;
      font-size: 18px;
    }

    .card a {
      display: inline-block;
      margin-top: 15px;
      color: #4e54c8;
      text-decoration: none;
      font-weight: bold;
    }

    .card a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Dashboard Admin</h2>
    <div>
      <a href="dashboard.php">Beranda</a>
      <a href="tampil_kamar.php">Kamar</a>
      <a href="tampil_reservasi.php">Reservasi</a>
      <a href="tampil_user.php">User</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Selamat Datang di Sistem Reservasi Hotel</h2>
    <div class="card-grid">
      <div class="card">
        <h3>Jumlah Kamar</h3>
        <p><?= $kamar['total_kamar'] ?> Kamar</p>
        <a href="tampil_kamar.php">Lihat Kamar →</a>
      </div>
      <div class="card">
        <h3>Total Reservasi</h3>
        <p><?= $reservasi['total_reservasi'] ?> Reservasi</p>
        <a href="tampil_reservasi.php">Lihat Reservasi →</a>
      </div>
      <div class="card">
        <h3>Jumlah User</h3>
        <p><?= $user['total_user'] ?> Pengguna</p>
        <a href="tampil_user.php">Lihat User →</a>
      </div>
    </div>
  </div>

</body>
</html>
