<?php
    include 'koneksidb.php';

    if (isset($_GET['id'])) {
        $id_kamar = $_GET['id'];

        $query = mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar = '$id_kamar'");
        $data = mysqli_fetch_array($query);

        if (!$data) {
            echo "<script>alert('Kamar tidak ditemukan!'); window.location='tampilkamar.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('ID kamar tidak ditemukan!'); window.location='tampilkamar.php';</script>";
        exit;
    }

    if (isset($_POST['submit'])) {
        $id_kamar = $_POST['id_kamar'];
        $tipe_kamar = $_POST['tipe_kamar'];
        $status = $_POST['status'];

        if ($tipe_kamar == "Single") {
            $harga = 150000;
        } else {
            $harga = 0;
        }

        $update_query = mysqli_query($koneksi, "UPDATE kamar SET tipe_kamar='$tipe_kamar', harga='$harga', status='$status' WHERE id_kamar='$id_kamar'");

        if ($update_query) {
            echo "<script>alert('Data kamar berhasil diubah!'); window.location='tampilkamar.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah data kamar!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 10px;
        }

        input, select {
            width: 100%;
            padding: 10px 0px 10px 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
        }

        .back-link a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Edit Kamar</h2>

    <form action="" method="POST">
        <label for="id_kamar">ID Kamar:</label>
        <input type="text" name="id_kamar" value="<?php echo $data['id_kamar']; ?>" readonly required>

        <label for="tipe_kamar">Tipe Kamar:</label>
        <select name="tipe_kamar" required>
            <option value="Single" <?php if ($data['tipe_kamar'] == 'Single') echo 'selected'; ?>>Single</option>
            <option value="Double" <?php if ($data['tipe_kamar'] == 'Double') echo 'selected'; ?>>Double</option>
            <option value="Deluxe" <?php if ($data['tipe_kamar'] == 'Deluxe') echo 'selected'; ?>>Deluxe</option>
            <option value="Suite" <?php if ($data['tipe_kamar'] == 'Suite') echo 'selected'; ?>>Suite</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Tersedia" <?php if ($data['status'] == 'Tersedia') echo 'selected'; ?>>Tersedia</option>
            <option value="Dipesan" <?php if ($data['status'] == 'Dipesan') echo 'selected'; ?>>Dipesan</option>
            <option value="Renovasi" <?php if ($data['status'] == 'Renovasi') echo 'selected'; ?>>Renovasi</option>
        </select>

        <button type="submit" name="submit">Update Kamar</button>
    </form>

    <div class="back-link">
        <a href="tampilkamar.php">Kembali ke Daftar Kamar</a>
    </div>

</body>
</html>
