<?php
    include 'koneksidb.php';

    if (isset($_POST['submit'])) {
        $id_kamar = $_POST['id_kamar'];
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
                        window.location = 'tambahkamar.php?change_id=true&id_kamar=$id_kamar&tipe_kamar=$tipe_kamar&harga=$harga&status=$status';
                    } else {
                        window.location = 'tambahkamar.php';
                    }
                </script>";
        } else {
            $insert_query = mysqli_query($koneksi, "INSERT INTO kamar (id_kamar, tipe_kamar, harga, status) VALUES ('$id_kamar', '$tipe_kamar', '$harga', '$status')");
            
            if ($insert_query) {
                echo "<script>alert('Kamar berhasil ditambahkan!'); window.location='tampilkamar.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menambahkan kamar!');</script>";
            }
        }
    }

    if (isset($_GET['change_id']) && $_GET['change_id'] == 'true') {
        $id_kamar = $_GET['id_kamar'];
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
            echo "<script>alert('ID kamar berhasil diubah!'); window.location='tampilkamar.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah ID kamar!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kamar</title>
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
            margin: 10px 0 5px;
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

    <h2>Tambah Kamar</h2>

    <form action="" method="POST">
        <label for="id_kamar">ID Kamar:</label>
        <input type="text" name="id_kamar" placeholder="Masukkan ID Kamar" required>

        <label for="tipe_kamar">Tipe Kamar:</label>
        <select name="tipe_kamar" required>
            <option value="Single">Single</option>
            <option value="Double">Double</option>
            <option value="Deluxe">Deluxe</option>
            <option value="Suite">Suite</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Tersedia">Tersedia</option>
            <option value="Tidak Tersedia">Tidak Tersedia</option>
            <option value="Renovasi">Renovasi</option>
        </select>

        <button type="submit" name="submit">Tambah Kamar</button>
    </form>

    <div class="back-link">
        <a href="tampilkamar.php">Kembali ke Daftar Kamar</a>
    </div>

</body>
</html>
