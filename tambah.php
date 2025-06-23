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

if (!isset($_GET['tipe'])) {
  die("Parameter tipe tidak ditentukan.");
}

$tipe = $_GET['tipe'];

if (isset($_POST['submit'])) {
  switch ($tipe) {
    case 'kamar':
      $tipe_kamar = $_POST['tipe_kamar'];
      $status = $_POST['status'];
      $harga;

      if ($tipe_kamar == "Single"){
        $harga = 150000;
        } elseif ($tipe_kamar == "Double"){
            $harga = 350000;
        } elseif ($tipe_kamar == "Deluxe"){
            $harga = 600000;
        } elseif ($tipe_kamar == "Suite"){
            $harga = 1000000;
        }
        

      mysqli_query($koneksi, "INSERT INTO kamar (tipe_kamar, harga, status) VALUES ('$tipe_kamar', '$harga', '$status')");
      header("Location: tampil_kamar.php");
      exit;

    case 'user':
      $nama = $_POST['nama'];
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $status = $_POST['status'];
      mysqli_query($koneksi, "INSERT INTO user (nama, username, password, status) VALUES ('$nama', '$username', '$password', '$status')");
      header("Location: tampil_user.php");
      exit;

    case 'reservasi':
      $id_user = $_POST['id_user'];
      $id_kamar = $_POST['id_kamar'];
      $tanggal_checkin = $_POST['tanggal_checkin'];
      $tanggal_checkout = $_POST['tanggal_checkout'];
      $query = mysqli_query($koneksi, "SELECT * FROM kamar where id_kamar = '$id_kamar'");
      $data_kamar = mysqli_fetch_assoc($query);
      $harga = $data_kamar['harga'];

      $tgl1 = new DateTime($tanggal_checkin);
      $tgl2 = new DateTime($tanggal_checkout);
      $jumlah_malam = $tgl2->diff($tgl1)->format("%a");
      $total_harga = $jumlah_malam * $harga;

      mysqli_query($koneksi, "INSERT INTO reservasi (id_user, id_kamar, tanggal_checkin, tanggal_checkout, total_harga) VALUES ('$id_user', '$id_kamar', '$tanggal_checkin', '$tanggal_checkout', '$total_harga')");
      mysqli_query($koneksi, "UPDATE kamar SET status='Dipesan' WHERE id_kamar='$id_kamar'");
      header("Location: tampil_reservasi.php");
      exit;
  }
}

if ($tipe == 'reservasi') {
  $users = mysqli_query($koneksi, "SELECT * FROM user");
  $kamars = mysqli_query($koneksi, "SELECT * FROM kamar WHERE status = 'Tersedia'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah <?= ucfirst($tipe) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f4f6fa; margin: 0; }
    .container {
      max-width: 500px; margin: 60px auto;
      background: white; padding: 30px;
      border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    h2 { text-align: center; color: #4e54c8; margin-bottom: 25px; }
    label {
      display: block; font-weight: 500;
      margin-bottom: 6px;
    }
    .form-control {
      width: 100%; padding: 10px 12px;
      margin-bottom: 18px; border: 1px solid #ccc;
      border-radius: 8px; font-size: 14px; box-sizing: border-box;
    }
    .btn-submit, .btn-back {
      width: 100%; padding: 12px; border-radius: 8px;
      font-weight: 500; font-size: 15px;
      display: block; text-align: center; text-decoration: none;
    }
    .btn-submit {
      background: #4e54c8; color: white; border: none;
      cursor: pointer; margin-top: 5px;
    }
    .btn-submit:hover { background: #3d44b6; }
    .btn-back {
      background: #ccc; color: #333;
      margin-top: 12px; transition: background 0.3s;
    }
    .btn-back:hover { background-color: #b3b3b3; }
  </style>
</head>
<body>

<div class="container">
  <h2>Form Tambah <?= ucfirst($tipe) ?></h2>
  <form method="POST">
    <?php if ($tipe == 'kamar'): ?>
      <label>Tipe Kamar</label>
      <select name="tipe_kamar" class="form-control" required>
        <option selected>Single</option>
        <option>Double</option>
        <option>Deluxe</option>
        <option>Suite</option>
      </select>

      <label>Status</label>
      <select name="status" class="form-control" required>
        <option value="Tersedia">Tersedia</option>
        <option value="Dipesan">Dipesan</option>
      </select>

    <?php elseif ($tipe == 'user'): ?>
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" required>

      <label>Username</label>
      <input type="text" name="username" class="form-control" required>

      <label>Password</label>
      <input type="password" name="password" class="form-control" required>

      <label>Status</label>
      <select name="status" class="form-control" required>
        <option>Pelanggan</option>
        <option>Admin</option>
      </select>

    <?php elseif ($tipe == 'reservasi'): ?>
      <label>User</label>
      <select name="id_user" class="form-control" required>
        <?php while ($u = mysqli_fetch_assoc($users)): ?>
          <option value="<?= $u['id_user'] ?>"><?= $u['nama'] ?></option>
        <?php endwhile; ?>
      </select>

      <label>Kamar</label>
      <select name="id_kamar" class="form-control" required>
        <?php while ($k = mysqli_fetch_assoc($kamars)): ?>
          <option value="<?= $k['id_kamar'] ?>"><?= $k['id_kamar'] ?> (<?= $k['tipe_kamar'] ?>)</option>
        <?php endwhile; ?>
      </select>

      <label>Check-in</label>
      <input type="date" name="tanggal_checkin" class="form-control" required>

      <label>Check-out</label>
      <input type="date" name="tanggal_checkout" class="form-control" required>

    <?php endif; ?>
        
    <button type="submit" class="btn-submit" name="submit">Simpan</button>
    <br>
    <a href="tampil_<?= $tipe ?>.php" style="
    ">← Kembali ke Halaman <?= ucfirst($tipe) ?></a>
  </form>
</div>

</body>
</html>
