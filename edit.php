<?php
include 'koneksidb.php';
session_start();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

if (!isset($_GET['id'])) {
    echo "ID kamar tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kamar = $_POST['nomor_kamar'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $status = $_POST['status'];

    $update = mysqli_query($koneksi, "UPDATE kamar SET id_kamar='$id_kamar', tipe_kamar='$tipe_kamar', status='$status' WHERE id_kamar='$id'");

    if ($update) {
        header("Location: tampil_kamar.php");
        exit;
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kamar | Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background-color: #f2f4f8;
    }

    .navbar {
      background: linear-gradient(45deg, #4e54c8, #8f94fb);
      color: #fff;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar h2 { margin: 0; font-weight: 600; }
    .navbar a { color: #fff; text-decoration: none; margin-left: 20px; font-weight: 500; }
    .navbar a:hover { text-decoration: underline; }

    .container {
      padding: 30px;
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    h2 {
      color: #4e54c8;
      margin-bottom: 25px;
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #333;
    }

    .form-control {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      background: #4e54c8;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: .3s;
    }

    .btn:hover {
      background-color: #3d44b6;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <h2>Edit Kamar</h2>
    <div>
      <a href="dashboard.php">Dashboard</a>
      <a href="tampil_kamar.php">Kamar</a>
      <a href="tampil_reservasi.php">Reservasi</a>
      <a href="tampil_user.php">User</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Form Edit Kamar</h2>
    <form method="POST">
      <label for="nomor_kamar">Nomor Kamar</label>
      <input type="text" name="nomor_kamar" id="nomor_kamar" class="form-control" value="<?= $data['id_kamar']?>" required>

      <label for="tipe_kamar">Tipe Kamar</label>
      <select name="tipe_kamar" id="tipe_kamar" class="form-control" required>
        <option value="" disabled>-- Pilih Tipe Kamar --</option>
        <option value="Single" <?= $data['tipe_kamar'] == 'Single' ? 'selected' : '' ?>>Single</option>
        <option value="Double" <?= $data['tipe_kamar'] == 'Double' ? 'selected' : '' ?>>Double</option>
        <option value="Deluxe" <?= $data['tipe_kamar'] == 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
        <option value="Suite" <?= $data['tipe_kamar'] == 'Suite' ? 'selected' : '' ?>>Suite</option>
      </select>

      <label for="status">Status</label>
      <select name="status" id="status" class="form-control" required>
        <option value="Tersedia" <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="Terisi" <?= $data['status'] == 'Terisi' ? 'selected' : '' ?>>Terisi</option>
      </select>

      <button type="submit" class="btn">Perbarui</button>
    </form>
  </div>

</body>
</html>
