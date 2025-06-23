<?php
session_start();
include 'koneksidb.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$safe_id_user = (int) $id_user;

$sql = "SELECT * FROM vw_detail_reservasi WHERE id_user = $id_user ORDER BY tanggal_checkin DESC";
$result = mysqli_query($koneksi, $sql);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($koneksi));
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Reservasi Anda - Hotel Kelompok 17</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: #f2f4f8; }
        .navbar { background: linear-gradient(45deg, #4e54c8, #8f94fb); color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; }
        .navbar .logo { font-size: 1.5rem; font-weight: 700; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; }
        .container { padding: 40px 5%; max-width: 1200px; margin: auto; }
        h2 { color: #4e54c8; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.06); }
        th, td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { background-color: #f9f9fc; color: #4e54c8; }
        tr:hover { background-color: #f9f9fc; }
        .no-data { text-align: center; padding: 50px; background: white; border-radius: 10px; }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; color: white; }
        .status-pending { background-color: #ffc107; color: #333; }
        .status-confirmed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }
    </style>
</head>
<body>

    <div class="navbar">
        <h2 class="logo"><a href="index.php" style="color:white; text-decoration:none;">Hotel Kelompok 17</a></h2>
        <div>
            <a href="index.php">Beranda</a>
            <a href="riwayat_reservasi.php">Reservasi Saya</a>
            <a>Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?></a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h2>Riwayat Reservasi Anda</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>No. Reservasi</th>
                        <th>No. Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($row['id_reservasi']); ?></td>
                        <td><?php echo htmlspecialchars($row['nomor_kamar']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipe_kamar']); ?></td>
                        <td><?php echo date("d M Y", strtotime($row['tanggal_checkin'])); ?></td>
                        <td><?php echo date("d M Y", strtotime($row['tanggal_checkout'])); ?></td>
                        <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <p>Anda belum memiliki riwayat reservasi. Silakan buat reservasi pertama Anda!</p>
                <a href="index.php#rooms" style="text-decoration:none; background-color:#4e54c8; color:white; padding:10px 20px; border-radius:8px;">Lihat Kamar</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
<?php
mysqli_close($koneksi);
?>