<?php
    include 'koneksidb.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kamar Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }

        .add-room {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }

        .add-room a {
            font-size: 16px;
            background-color: #ff5722;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }

        .add-room a:hover {
            background-color: #e64a19;
        }


        table {
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        td:last-child {
            text-align: center;
        }

    </style>
</head>
<body>
    <h2>Daftar Kamar Hotel</h2>

    <div class="add-room">
        <a href='tambahkamar.php'>Tambah Kamar</a>
    </div>
    
    <table>
        <tr>
            <th>No</th>
            <th>ID Kamar</th>
            <th>Tipe Kamar</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
            $no = 1;
            $query = mysqli_query($koneksi, "select * from kamar");
            while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['id_kamar'] ?></td>
                <td><?php echo $data['tipe_kamar'] ?></td>
                <td><?php echo "Rp. ".$data['harga'] ?></td>
                <td><?php echo $data['status'] ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $data['id_kamar']?>">Edit</a>
                    <a href="hapus.php?id=<?php echo $data['id_kamar']?>">Hapus</a>
                </td>
            </tr>
        <?php
            }
        ?>
    </table>
</body>
</html>
