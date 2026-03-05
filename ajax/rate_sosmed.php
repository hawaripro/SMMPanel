<?php
session_start();
require("../config.php");
if (!isset($_SESSION['user'])) {
    die("Anda Tidak Memiliki Akses!");
}
if (isset($_POST['layanan'])) {
    $post_layanan = $conn->real_escape_string($_POST['layanan']);
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_layanan' AND status = 'Aktif'");
    if (mysqli_num_rows($cek_layanan) == 1) {
        $data_layanan = mysqli_fetch_assoc($cek_layanan);
        $cek_diskon = $conn->query("SELECT * FROM users WHERE username = '" . $_SESSION['user']['username'] . "'");
        $data_diskon = mysqli_fetch_assoc($cek_diskon);
        if ($data_diskon['diskon_user'] == "0") {
            $result = $data_layanan['harga'] / 1000;
        } else {
            $ht = $data_layanan['harga'] / 1000;
            $ST = (($ht * $data_diskon['diskon_user']) / 100);
            $result = $ht - $ST;
        }
        echo "" . $result . "";
    } else {
        die("0");
    }
} else {
    die("0");
}
