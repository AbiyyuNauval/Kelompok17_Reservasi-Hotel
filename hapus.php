<?php
    include 'koneksidb.php';

    if (isset($_GET['id'])) {
        $id_kamar = $_GET['id'];

        $delete_query = mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kamar='$id_kamar'");

        if ($delete_query) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='tampilkamar.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus data!'); window.location='tampilkamar.php';</script>";
        }
    } else {
        echo "<script>alert('ID kamar tidak ditemukan!'); window.location='tampilkamar.php';</script>";
    }
?>
