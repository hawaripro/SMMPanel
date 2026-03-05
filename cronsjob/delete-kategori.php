<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
$delet_kategori = mysqli_query($conn, "TRUNCATE TABLE kategori_layanan");
$delet_service = mysqli_query($conn, "TRUNCATE TABLE layanan_sosmed");
if($delet_kategori == TRUE){
    $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Semua Kategori & Layanan Berhasil Di Hapus');
     
    exit(header("Location: " . $config['web']['url'] . "admin/kelola-kategori"));
}else{
    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'gagal', 'pesan' => 'Kategori & Layanan Gagal Di Hapus');
     
   exit(header("Location: " . $config['web']['url'] . "admin/kelola-kategori"));
}
?>