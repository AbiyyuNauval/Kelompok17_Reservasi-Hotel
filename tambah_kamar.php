<?php
include 'koneksidb.php';
session_start();
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit;
// }

if (isset($_POST['submit'])) {
        $id_kamar = $_POST['nomor_kamar'];
        $tipe_kamar = $_POST['tipe_kamar'];
        $status = $_POST['status'];
        $harga;

        if ($tipe_kamar == "Single"){
            $harga = 150000;
        } else {
            $harga = 0;
        }

        $check_query = mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar = '$id_kamar'");
        if (mysqli_num_rows($check_query) > 0) {
            echo "<script>
                    if (confirm('ID Kamar sudah ada. Apakah Anda ingin mengubah ID Kamar?')) {
                        window.location = 'tambah_kamar.php';
                    } else {
                        window.location = 'tambah_kamar.php?change_id=true&id_kamar=$id_kamar&tipe_kamar=$tipe_kamar&harga=$harga&status=$status';
                    }
                </script>";
        } else {
            $insert_query = mysqli_query($koneksi, "INSERT INTO kamar (id_kamar, tipe_kamar, harga, status) VALUES ('$id_kamar', '$tipe_kamar', '$harga', '$status')");
            
            if ($insert_query) {
                echo "<script>alert('Kamar berhasil ditambahkan!'); window.location='tampil_kamar.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menambahkan kamar!');</script>";
            }
        }
    }

    if (isset($_GET['change_id']) && $_GET['change_id'] == 'true') {
        $id_kamar = $_GET['nomor_kamar'];
        $tipe_kamar = $_GET['tipe_kamar'];
        $status = $_GET['status'];
        $harga;

        if ($tipe_kamar == "Single"){
            $harga = 150000;
        } else {
            $harga = 0;
        }

        $update_query = mysqli_query($koneksi, "UPDATE kamar SET id_kamar='$id_kamar', tipe_kamar='$tipe_kamar', harga='$harga', status='$status' WHERE id_kamar='$id_kamar'");
        
        if ($update_query) {
            echo "<script>alert('ID kamar berhasil diubah!'); window.location='tampil_kamar.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah ID kamar!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kamar | Admin</title>
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

    .navbar h2 { margin: 0; font-weight: 600; color: white; }
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
    <h2>Tambah Kamar</h2>
    <div>
      <a href="dashboard.php">Dashboard</a>
      <a href="tampil_kamar.php">Kamar</a>
      <a href="tampilreservasi.php">Reservasi</a>
      <a href="tampiluser.php">User</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>Form Tambah Kamar</h2>
    <form action="tambah_kamar.php" method="POST">
      <label for="nomor_kamar">Nomor Kamar</label>
      <input type="text" name="nomor_kamar" id="nomor_kamar" class="form-control" required>

      <label for="tipe_kamar">Tipe Kamar</label>
      <select name="tipe_kamar" id="tipe_kamar" class="form-control" required>
        <option value="" disabled selected>Pilih Tipe Kamar</option>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
        <option value="Deluxe">Deluxe</option>
        <option value="Suite">Suite</option>
      </select>

      <label for="status">Status</label>
      <select name="status" id="status" class="form-control" required>
        <option value="Tersedia">Tersedia</option>
        <option value="Terisi">Terisi</option>
      </select>

      <button type="submit" class="btn" name="submit">Simpan</button>
    </form>
  </div>

</body>
</html>
