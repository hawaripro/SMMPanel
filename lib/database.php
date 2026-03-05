<?php
// ===== Halaman Admin ===== //
//Count Users
$total_pengguna = mysqli_num_rows($conn->query("SELECT * FROM users"));
//Total saldo user
$total_saldoUser = $conn->query("SELECT SUM(saldo) AS total FROM users");
$data_saldoUser = $total_saldoUser->fetch_assoc();
//Count Pesanan
$count_pesanan_sosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed"));
//Total Pemesanan
$total_pemesanan_sosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed");
$data_pesanan_sosmed = $total_pemesanan_sosmed->fetch_assoc();
//Count Deposit
$count_deposit = mysqli_num_rows($conn->query("SELECT * FROM deposit WHERE status = 'Success'"));
//Total Deposit
$total_deposit = $conn->query("SELECT SUM(jumlah_transfer) AS total FROM deposit WHERE status = 'Success'");
$data_deposit = $total_deposit->fetch_assoc();

// Total Profit Pembelian Sosmed Perbulan
$ThisProfitSosmed = $conn->query("SELECT SUM(profit) AS total FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'");
$ProfitSosmed = $ThisProfitSosmed->fetch_assoc();

$ThisTotalSosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'");
$AllSosmed = $ThisTotalSosmed->fetch_assoc();

$CountProfitSosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE MONTH(pembelian_sosmed.date) = '".date('m')."' AND YEAR(pembelian_sosmed.date) = '".date('Y')."'"));

// TOTAL LAYANAN //
$layanan_total =  mysqli_num_rows($conn->query("SELECT * FROM layanan_sosmed"));

// TOTAL LAYANAN AKTIF //
$layanan_aktif =  mysqli_num_rows($conn->query("SELECT * FROM layanan_sosmed WHERE status = 'Aktif'"));
// TOTAL LAYANAN TIDAK AKTIF //
$layanan_Tidak_aktif =  mysqli_num_rows($conn->query("SELECT * FROM layanan_sosmed WHERE status = 'Tidak Aktif'"));

// DEPOSIT QRIS //
$panggil_QRIS = $conn->query("SELECT * FROM logo_qris WHERE id = '1'");
$data_QRIS = $panggil_QRIS->fetch_assoc();

// PAymEnT gatEWAY //
$DT_Pgateway = $conn->query("SELECT * FROM yabgroup WHERE id = '1'");
$data_Pgateway = $DT_Pgateway->fetch_assoc();

// EMAIL HOSTING //
$E_hosting = $conn->query("SELECT * FROM email_hosting WHERE id = '1'");
$data_hosting = $E_hosting->fetch_assoc();

// ===== Data Tiket ===== //
$AllTiketUsers = $conn->query("SELECT * FROM tiket WHERE status = 'Pending'");
// ======================== //

// ===== ============ ===== //

// ===== Halaman Pengguna ===== //
// Data User
    $jumlah_order_sosmed = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE user = '$sess_username'"));
    $jumlah_deposit_user = mysqli_num_rows($conn->query("SELECT * FROM deposit WHERE username = '$sess_username' AND status = 'Success'"));
   $total_deposit_user = $conn->query("SELECT SUM(jumlah_transfer) AS total FROM deposit WHERE username = '$sess_username' AND status = 'Success'");
   $data_deposit_user = $total_deposit_user->fetch_assoc();

    $cek_order_sosmed = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE user = '$sess_username'");
    $data_order_sosmed = $cek_order_sosmed->fetch_assoc();    
// ===== ============== ===== //

// ===== Data Halaman Kontak ===== //
    $CallDbHalaman = $conn->query("SELECT * FROM halaman WHERE id = '1'");
    $PageContact = $CallDbHalaman->fetch_assoc();
// ======================== //

// ===== Data Tiket ===== //
    $CallDBTiket = $conn->query("SELECT * FROM tiket WHERE status = 'Responded' AND user = '$sess_username'");
// ======================== //

// ===== Data Website ===== //
    $panggil = $conn->query("SELECT * FROM setting_web WHERE id = '1'");
    $data = $panggil->fetch_assoc();
    
    
// ======================== //
$total_depo_succes = mysqli_num_rows($conn->query("SELECT * FROM deposit WHERE status = 'Success'"));
$total_depo_error = mysqli_num_rows($conn->query("SELECT * FROM deposit WHERE status = 'Error'"));
$total_depo_pending = mysqli_num_rows($conn->query("SELECT * FROM deposit WHERE status = 'Pending'"));

$total_sosmed_succes = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'Success'"));
$total_pemesanan_sosmed_success = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'Success'");
$data_pesanan_sosmed_success = $total_pemesanan_sosmed_success->fetch_assoc();

$total_sosmed_error = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'Error'"));
$total_pemesanan_sosmed_error = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'Error'");
$data_pesanan_sosmed_error = $total_pemesanan_sosmed_error->fetch_assoc();

$total_sosmed_pending = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'Pending'"));
$total_pemesanan_sosmed_pending = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'Pending'");
$data_pesanan_sosmed_pending = $total_pemesanan_sosmed_pending->fetch_assoc();

$total_sosmed_partial = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'Partial'"));
$total_pemesanan_sosmed_partial = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'Partial'");
$data_pesanan_sosmed_partial = $total_pemesanan_sosmed_partial->fetch_assoc();

$total_sosmed_processing = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'Processing'"));
$total_pemesanan_sosmed_processing = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'Processing'");
$data_pesanan_sosmed_processing = $total_pemesanan_sosmed_processing->fetch_assoc();

$total_sosmed_progress = mysqli_num_rows($conn->query("SELECT * FROM pembelian_sosmed WHERE status = 'In Progress'"));
$total_pemesanan_sosmed_progress = $conn->query("SELECT SUM(harga) AS total FROM pembelian_sosmed WHERE status = 'In Progress'");
$data_pesanan_sosmed_progress = $total_pemesanan_sosmed_progress->fetch_assoc();

$aktif =  mysqli_num_rows($conn->query("SELECT * FROM users WHERE status = 'Aktif'"));
$nonaktif =  mysqli_num_rows($conn->query("SELECT * FROM users WHERE status = 'Tidak Aktif'"));
?>