<?php
include 'koneksidb.php';
session_start();
if (!isset($_SESSION['id_user'])) {
  header('Location: login.php');
  exit;
}
if ($_SESSION['status'] != 'Admin'){
  die("Akses ditolak.");
exit;
}

$reservasi = mysqli_query($koneksi, "
  SELECT r.*, u.nama, k.id_kamar 
  FROM reservasi r 
  JOIN user u ON r.id_user = u.id_user 
  JOIN kamar k ON r.id_kamar = k.id_kamar
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Reservasi | Admin</title>
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
      color: white;
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

    h2 {
      color: #4e54c8;
      margin-bottom: 20px;
    }

    .btn {
      display: inline-block;
      padding: 10px 16px;
      background-color: #4e54c8;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 500;
      margin-bottom: 20px;
      transition: 0.3s ease;
    }

    .btn:hover {
      background-color: #3f45b3;
      transform: scale(1.05);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #f0f0f0;
    }

    th {
      background-color: #f9f9fc;
      color: #4e54c8;
    }

    tr:hover {
      background-color: #f9f9fc;
    }

    .aksi a {
      display: inline-block;
      margin-right: 8px;
      padding: 6px 10px;
      font-size: 13px;
      font-weight: 500;
      text-decoration: none;
      border-radius: 6px;
      color: white;
    }

    .edit {
      background-color: #4e9af1;
      transition: 0.3s ease;
    }

    .delete {
      background-color: #e74c3c;
      transition: 0.3s ease;
    }

    .edit:hover {
      background-color: #3e89d1;
      transform: scale(1.07);
    }

    .delete:hover {
      background-color: #c0392b;
      transform: scale(1.07);
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Data Reservasi</h2>
    <div>
      <a href="dashboard.php">Dashboard</a>
      <a href="tampil_kamar.php">Kamar</a>
      <a href="tampil_reservasi.php">Reservasi</a>
      <a href="tampil_user.php">User</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Daftar Reservasi Hotel</h2>
    <a class="btn" href="tambah.php?tipe=reservasi">+ Tambah Reservasi</a>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama User</th>
          <th>No Kamar</th>
          <th>Check-in</th>
          <th>Check-out</th>
          <th>Total Harga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($d = mysqli_fetch_array($reservasi)) { ?>
          <?php$tipekamar = mysqli_query($koneksi, "SELECT tipe_kamar FROM kamar where id_kamar='$d['id_kamar']'");?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama'] ?></td>
            <td><?= $d['id_kamar'] ?></td>
            <td><?= $d['tanggal_checkin'] ?></td>
            <td><?= $d['tanggal_checkout'] ?></td>
            <td>Rp <?= number_format($d['total_harga'], 0, ',', '.') ?></td>
            
            <td class="aksi">
              <a class="edit" href="edit.php?tipe=reservasi&id=<?= $d['id_reservasi'] ?>">Edit</a>
              <a class="delete" href="hapus.php?tipe=reservasi&id=<?= $d['id_reservasi'] ?>" onclick="return confirm('Hapus reservasi ini?')">Hapus</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>





