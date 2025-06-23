<?php
session_start();
include 'koneksidb.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}
if ($_SESSION['status'] != 'Admin'){
  die("Akses ditolak.");
  exit;
}

// Count
$kamar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_kamar FROM kamar"));
$reservasi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_reservasi FROM reservasi"));
$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_user FROM user"));
$kamar_tersedia = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_tersedia FROM kamar where status='Tersedia'"));
$kamar_dipesan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_dipesan FROM kamar where status='Dipesan'"));
$pelanggan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_pelanggan FROM user where status='Pelanggan'"));
$admin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total_admin FROM user where status='Admin'"));

// Max
$kamar_termahal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT MAX(harga) AS harga_termahal FROM kamar"));
$reservasi_termahal = mysqli_fetch_array(mysqli_query($koneksi, "SELECT MAX(total_harga) AS rsv_termahal FROM reservasi"));

// Min
$kamar_termurah = mysqli_fetch_array(mysqli_query($koneksi, "SELECT MIN(harga) AS harga_termurah FROM kamar"));
$reservasi_termurah = mysqli_fetch_array(mysqli_query($koneksi, "SELECT MIN(total_harga) AS rsv_termurah FROM reservasi"));

// Avg
$rata_reservasi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT AVG(total_harga) AS rata_rsv FROM reservasi"));

// Sum
$total_pendapatan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total_harga) AS pendapatan FROM reservasi"));

// Function
$ketersediaan = mysqli_query($koneksi, 
  "SELECT tipe_kamar, HitungKamarTersedia(tipe_kamar) AS jumlah_tersedia FROM kamar
   GROUP BY tipe_kamar");
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
      grid-template-columns: repeat(3, minmax(250px, 1fr)); 
      gap: 20px; 
      margin-top: 30px; 
    }
    .card { 
      position: relative;
      background-color: white; 
      border-radius: 12px; 
      box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
      padding: 20px; 
      transition: 0.3s ease; 
    }
    .card:hover { 
      transform: translateY(-5px); 
      z-index: 20;
    }
    .card h3 { 
      margin: 0; 
      color: #4e54c8; 
    }
    .card p { 
      margin-top: 10px; 
      font-size: 18px; 
      font-weight: 600; 
    }
    .card small { 
      font-size: 14px; 
      color: #777; 
    }

    .hover-details {
        display: none; /* Sembunyi secara default */
        position: absolute;
        top: 100%; /* Muncul tepat di bawah card */
        left: 0;
        width: 100%;
        background-color: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        padding: 15px 20px;
        box-sizing: border-box;
        z-index: 10;
        text-align: left;
    }

    /* Tampilkan kotak detail saat card di-hover */
    .card:hover .hover-details {
        display: block;
    }

    /* Styling untuk list di dalam kotak detail */
    .hover-details ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .hover-details li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .hover-details li:last-child {
        border-bottom: none;
    }
    .hover-details .kamar-tipe {
        font-weight: 500;
        color: #555;
    }
    .hover-details .kamar-jumlah {
        font-weight: 600;
        color: #4e54c8;
    }
  </style>
</head>
<body>

<div class="navbar">
    <h2>Dashboard Admin</h2>
    <div>
      <a href="dashboard.php">Dashboard</a>
      <a href="tampil_kamar.php">Kamar</a>
      <a href="tampil_reservasi.php">Reservasi</a>
      <a href="tampil_user.php">User</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Sistem Reservasi Hotel</h2>
    
    <div class="card-grid">
      <div class="card">
        <h3>Total Pendapatan</h3>
        <p>Rp <?= number_format($total_pendapatan['pendapatan'] ?? 0, 0, ',', '.') ?></p>
        <small>Dari <?= $reservasi['total_reservasi'] ?> Reservasi</small>
      </div>
       <div class="card">
        <h3>Rata-rata/Reservasi</h3>
        <p>Rp <?= number_format($rata_reservasi['rata_rsv'] ?? 0, 0, ',', '.') ?></p>
         <small>Nilai rata-rata per transaksi</small>
      </div>
      <div class="card">
        <h3>Total Kamar</h3>
        <p><?= $kamar['total_kamar'] ?> Kamar</p>
        
        <div class="hover-details">
        <ul>
            <?php while($detail = mysqli_fetch_assoc($ketersediaan)): ?>
                <li>
                    <span class="kamar-tipe"><?php echo $detail['tipe_kamar']; ?></span>
                    <span class="kamar-jumlah"><?php echo $detail['jumlah_tersedia']; ?> Tersedia</span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
      </div>
    </div>

    <h2 style="margin-top: 40px;">Statistik Lainnya</h2>
    <div class="card-grid">
        <div class="card">
            <h3>Harga Kamar Termahal</h3>
            <p>Rp <?= number_format($kamar_termahal['harga_termahal'] ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="card">
            <h3>Reservasi Termahal</h3>
            <p>Rp <?= number_format($reservasi_termahal['rsv_termahal'] ?? 0, 0, ',', '.') ?> </p>
        </div>
        <div class="card">
            <h3>Harga Kamar Termurah</h3>
            <p>Rp <?= number_format($kamar_termurah['harga_termurah'] ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="card">
            <h3>Reservasi Termurah</h3>
            <p>Rp <?= number_format($reservasi_termurah['rsv_termurah'] ?? 0, 0, ',', '.') ?></p>
        </div>
        <div class="card">
            <h3>Total Pengguna</h3>
            <p><?= $user['total_user'] ?> Pengguna</p>
            <small>Pelanggan: <?= $pelanggan['total_pelanggan'] ?> | Admin: <?= $admin['total_admin'] ?></small>
        </div>
    </div>
  </div>

</body>
</html>
