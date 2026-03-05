<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
//$delet_service = mysqli_query($conn, "TRUNCATE TABLE kategori_layanan");
$delet_service = mysqli_query($conn, "TRUNCATE TABLE layanan_sosmed");
if($delet_service == TRUE){
    $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Semua Layanan Berhasil Di Hapus');
     
    exit(header("Location: " . $config['web']['url'] . "admin/kelola-layanan"));
}else{
    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'gagal', 'pesan' => 'Layanan Gagal Di Hapus');
     
   exit(header("Location: " . $config['web']['url'] . "admin/kelola-layanan"));
}
?>