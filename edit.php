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

if (!isset($_GET['tipe']) || !isset($_GET['id'])) {
  die("Parameter tidak lengkap.");
}

$tipe = $_GET['tipe'];
$id   = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch ($tipe) {
    case 'kamar':
      $tipe_kamar = $_POST['tipe_kamar'];
      $status = $_POST['status'];

      if ($tipe_kamar == "Single"){
        $harga = 150000;
        } elseif ($tipe_kamar == "Double"){
            $harga = 350000;
        } elseif ($tipe_kamar == "Deluxe"){
            $harga = 600000;
        } elseif ($tipe_kamar == "Suite"){
            $harga = 1000000;
        }

      mysqli_query($koneksi, "UPDATE kamar SET tipe_kamar='$tipe_kamar', harga='$harga', status='$status' WHERE id_kamar=$id");
      header("Location: tampil_kamar.php");
      exit;

    case 'user':
      $nama = $_POST['nama'];
      $username = $_POST['username'];
      $status = $_POST['status'];
      mysqli_query($koneksi, "UPDATE user SET nama='$nama', username='$username', status='$status' WHERE id_user=$id");
      header("Location: tampil_user.php");
      exit;

    case 'reservasi':
      $id_user = $_POST['id_user'];
      $id_kamar = $_POST['id_kamar'];
      $tanggal_checkin = $_POST['tanggal_checkin'];
      $tanggal_checkout = $_POST['tanggal_checkout'];
      mysqli_query($koneksi, "UPDATE reservasi SET id_user='$id_user', id_kamar='$id_kamar', tanggal_checkin='$tanggal_checkin', tanggal_checkout='$tanggal_checkout' WHERE id_reservasi=$id");
      header("Location: tampil_reservasi.php");
      exit;
  }
}

// === AMBIL DATA SAAT FORM DIBUKA ===
switch ($tipe) {
  case 'kamar':
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar = $id"));
    break;

  case 'user':
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id"));
    break;

  case 'reservasi':
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM reservasi WHERE id_reservasi = $id"));
    $users = mysqli_query($koneksi, "SELECT * FROM user");
    $kamars = mysqli_query($koneksi, "SELECT * FROM kamar");
    break;

  default:
    die("Tipe tidak dikenali.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit <?= ucfirst($tipe) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f4f6fa; margin: 0; }
    .container {
      max-width: 500px; margin: 60px auto;
      background: white; padding: 30px;
      border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    h2 {
      text-align: center; color: #4e54c8;
      margin-bottom: 25px;
    }
    label {
      display: block; font-weight: 500;
      margin-bottom: 6px;
    }
    .form-control {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      box-sizing: border-box;
    }
    .btn-submit,
    .btn-back {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      font-weight: 500;
      font-size: 15px;
      display: block;
      text-align: center;
      text-decoration: none;
    }
    .btn-submit {
      background-color: #4e54c8;
      color: white;
      border: none;
      margin-top: 5px;
      cursor: pointer;
    }
    .btn-submit:hover {
      background-color: #3d44b6;
    }
    .btn-back {
      background-color: #ccc;
      color: #333;
      margin-top: 12px;
      transition: background 0.3s;
    }
    .btn-back:hover {
      background-color: #b3b3b3;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Edit <?= ucfirst($tipe) ?></h2>
  <form method="POST">
    <?php if ($tipe == 'kamar'): ?>
      <label>Nomor Kamar</label>
      <input type="text" name="id_kamar" class="form-control" value="<?= $data['id_kamar'] ?>" required>

      <label>Tipe Kamar</label>
      <select name="tipe_kamar" class="form-control" required>
        <option <?= $data['tipe_kamar'] == 'Single' ? 'selected' : '' ?>>Single</option>
        <option <?= $data['tipe_kamar'] == 'Double' ? 'selected' : '' ?>>Double</option>
        <option <?= $data['tipe_kamar'] == 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
        <option <?= $data['tipe_kamar'] == 'Suite' ? 'selected' : '' ?>>Suite</option>
      </select>

      <label>Status</label>
      <select name="status" class="form-control" required>
        <option <?= $data['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option <?= $data['status'] == 'Dipesan' ? 'selected' : '' ?>>Dipesan</option>
      </select>

    <?php elseif ($tipe == 'user'): ?>
      <label>Nama</label>
      <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>

      <label>Username</label>
      <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>

      <label>Status</label>
      <select name="status" class="form-control">
        <option <?= $data['status'] == 'Pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
        <option <?= $data['status'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
      </select>

    <?php elseif ($tipe == 'reservasi'): ?>
      <label>User</label>
      <select name="id_user" class="form-control" required>
        <?php while ($u = mysqli_fetch_assoc($users)) : ?>
          <option value="<?= $u['id_user'] ?>" <?= $data['id_user'] == $u['id_user'] ? 'selected' : '' ?>><?= $u['nama'] ?></option>
        <?php endwhile; ?>
      </select>

      <label>Kamar</label>
      <select name="id_kamar" class="form-control" required>
        <?php while ($k = mysqli_fetch_assoc($kamars)) : ?>
          <option value="<?= $k['id_kamar'] ?>" <?= $data['id_kamar'] == $k['id_kamar'] ? 'selected' : '' ?>>
            <?= $k['id_kamar'] ?> (<?= $k['tipe_kamar'] ?>)
          </option>
        <?php endwhile; ?>
      </select>

      <label>Check-in</label>
      <input type="date" name="tanggal_checkin" class="form-control" value="<?= $data['tanggal_checkin'] ?>" required>

      <label>Check-out</label>
      <input type="date" name="tanggal_checkout" class="form-control" value="<?= $data['tanggal_checkout'] ?>" required>

    <?php endif; ?>

    <button type="submit" class="btn-submit">Simpan Perubahan</button>
    <br>
    <a href="tampil_<?= $tipe ?>.php" style="
    ">← Kembali ke Halaman <?= ucfirst($tipe) ?></a>
  </form>
</div>

</body>
</html>
