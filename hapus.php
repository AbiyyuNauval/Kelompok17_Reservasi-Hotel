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

if (isset($_GET['tipe']) && isset($_GET['id'])) {
    $tipe = $_GET['tipe'];
    $id = intval($_GET['id']);

    switch ($tipe) {
        case 'kamar':
            $query = mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kamar = $id");
            $redirect = "tampil_kamar.php";
            break;

        case 'user':
            $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id");
            $redirect = "tampil_user.php";
            break;

        case 'reservasi':
            // ambil id_kamar agar bisa diubah statusnya ke 'Tersedia' lagi
            $get = mysqli_query($koneksi, "SELECT id_kamar FROM reservasi WHERE id_reservasi = $id");
            $data = mysqli_fetch_assoc($get);
            $id_kamar = $data['id_kamar'];

            // hapus reservasi
            $query = mysqli_query($koneksi, "DELETE FROM reservasi WHERE id_reservasi = $id");

            // ubah status kamar
            if ($id_kamar) {
                mysqli_query($koneksi, "UPDATE kamar SET status='Tersedia' WHERE id_kamar = $id_kamar");
            }

            $redirect = "tampil_reservasi.php";
            break;

        default:
            die("Tipe tidak dikenali.");
    }

    if ($query) {
        header("Location: $redirect");
        exit;
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "Parameter tidak lengkap.";
}
?>
