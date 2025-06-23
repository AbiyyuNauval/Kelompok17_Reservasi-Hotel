<?php
session_start();
include 'koneksidb.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['tipe'])) {
    die("Error: Tipe Kamar tidak valid.");
}

$tipe_kamar_dipilih = mysqli_real_escape_string($koneksi, $_GET['tipe']);
$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama'];

$sql_display = "SELECT * FROM kamar WHERE tipe_kamar = '$tipe_kamar_dipilih' LIMIT 1";
$result_display = mysqli_query($koneksi, $sql_display);

if (!$result_display || mysqli_num_rows($result_display) == 0) {
    die("Error: Tipe kamar tidak ditemukan.");
}
$kamar_display = mysqli_fetch_assoc($result_display);

$sql_avail = "SELECT id_kamar FROM kamar WHERE tipe_kamar = '$tipe_kamar_dipilih' AND status = 'Tersedia'";
$result_avail = mysqli_query($koneksi, $sql_avail);
$kamar_tersedia = ($result_avail && mysqli_num_rows($result_avail) > 0);

if ($_SERVER["REQUEST_METHOD"] == "POST" && $kamar_tersedia) {
    
    mysqli_autocommit($koneksi, false);

    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $is_transaction_success = false;

    try {
        $sql_find_room = "SELECT id_kamar, harga FROM kamar WHERE tipe_kamar = '$tipe_kamar_dipilih' AND status = 'Tersedia' ORDER BY id_kamar ASC LIMIT 1 FOR UPDATE";
        $result_find = mysqli_query($koneksi, $sql_find_room);

        if ($result_find && mysqli_num_rows($result_find) > 0) {
            $kamar_dipesan = mysqli_fetch_assoc($result_find);
            $id_kamar_final = $kamar_dipesan['id_kamar'];
            $harga = $kamar_dipesan['harga'];

            $sql_update_status = "UPDATE kamar SET status = 'Dipesan' WHERE id_kamar = $id_kamar_final";
            $result_update = mysqli_query($koneksi, $sql_update_status);

            $tgl1 = new DateTime($check_in);
            $tgl2 = new DateTime($check_out);
            $jumlah_malam = $tgl2->diff($tgl1)->format("%a");
            $total_harga = $jumlah_malam * $harga;
            
            $safe_check_in = mysqli_real_escape_string($koneksi, $check_in);
            $safe_check_out = mysqli_real_escape_string($koneksi, $check_out);
            
            $sql_insert_reservasi = "INSERT INTO reservasi (id_user, id_kamar, tanggal_checkin, tanggal_checkout, total_harga) VALUES ($id_user, $id_kamar_final, '$safe_check_in', '$safe_check_out', $total_harga)";
            $result_insert = mysqli_query($koneksi, $sql_insert_reservasi);
            if ($result_update && mysqli_affected_rows($koneksi) > 0 && $result_insert) {
                mysqli_commit($koneksi);
                $is_transaction_success = true;
                
                $new_reservasi_id = mysqli_insert_id($koneksi);
                header("Location: index.php");
                exit;
            } else {
                throw new Exception("Gagal mengupdate status atau membuat reservasi.");
            }
        } else {
            $error_message = "Maaf, kamar dengan tipe ini baru saja habis dipesan. Silakan pilih tipe lain.";
        }
    } catch (Exception $e) {
        $error_message = "Terjadi kesalahan pada server: " . $e->getMessage();
    }

    if (!$is_transaction_success) {
        mysqli_rollback($koneksi);
    }
    
    mysqli_autocommit($koneksi, true);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !$kamar_tersedia) {
    $error_message = "Tidak dapat memproses, kamar dengan tipe ini sudah tidak tersedia.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Kamar <?php echo htmlspecialchars($tipe_kamar_dipilih); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f2f4f8; margin: 0; padding: 40px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        h1 { color: #4e54c8; }
        .kamar-detail img { width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 20px; }
        .kamar-detail h2 { margin-top: 0; }
        .kamar-detail .price { font-size: 1.5rem; font-weight: 600; color: #333; }
        hr { border: 1px solid #eee; margin: 30px 0; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; border: none; border-radius: 8px; background: linear-gradient(45deg, #4e54c8, #8f94fb); color: white; font-size: 1rem; font-weight: 600; cursor: pointer; transition: opacity 0.3s ease; }
        .btn:hover { opacity: 0.9; }
        .btn:disabled { background: #ccc; cursor: not-allowed; }
        .error-msg, .info-msg { text-align: center; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .error-msg { background-color: #dc3545; }
        .info-msg { background-color: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulir Reservasi</h1>
        <p>Anda login sebagai: <strong><?php echo htmlspecialchars($nama_user); ?></strong></p>
        <hr>
        <div class="kamar-detail">
            <?php
                $gambar = [
                    'Single' => 'Single.jpg',
                    'Double' => 'Double.jpg',
                    'Deluxe' => 'Deluxe.jpeg',
                    'Suite' => 'Suite.jpg'
                ];

                $nama_file = $gambar[$kamar_display['tipe_kamar']];
            ?>
            <img src="Gambar/<?php echo $nama_file; ?>" alt="<?php echo htmlspecialchars($kamar_display['tipe_kamar']); ?>
            <h2>Tipe Kamar: <?php echo htmlspecialchars($kamar_display['tipe_kamar']); ?></h2>
            <div class="price">Rp <?php echo number_format($kamar_display['harga'], 0, ',', '.'); ?> <span>/ malam</span></div>
        </div>
        <hr>
        
        <?php if ($kamar_tersedia): ?>
            <form action="reservasi.php?tipe=<?php echo htmlspecialchars($tipe_kamar_dipilih); ?>" method="POST">
                <h3>Pilih Tanggal</h3>
                <?php if (!empty($error_message)): ?>
                    <div class="error-msg"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="check_in">Tanggal Check-in</label>
                    <input type="date" id="check_in" name="check_in" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label for="check_out">Tanggal Check-out</label>
                    <input type="date" id="check_out" name="check_out" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                </div>
                <button type="submit" class="btn">Konfirmasi Reservasi</button>
            </form>
        <?php else: ?>
            <div class="info-msg">
                <strong>Mohon Maaf!</strong><br>
                Kamar dengan tipe "<?php echo htmlspecialchars($tipe_kamar_dipilih); ?>" saat ini sudah penuh dipesan.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>