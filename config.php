<?php

//<!--

// YOUTUBE CODING KEBUMEN //

// PHONE 083191910986 //

// DI LARANG KERAS MEMPERJUALBELIKAN SCRIPT INI TANPA IZIN //

//-->

date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
$maintenance = 1; //** 1 = ya ..  0 = tidak
if($maintenance == 0) {
    die("Site under Maintenance.");
}
// database
$config['db'] = array(
	'host' => 'localhost',
	'name' => 'kingspe1_pfcsmmppob',
	'username' => 'kingspe1_pfcsmmppob',
	'password' => 'kingspe1_pfcsmmppob'
);

$conn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
if(!$conn) {
	die("Koneksi Gagal : ".mysqli_connect_error());
	}
$config['web'] = array(
	'url' => 'https://pfcsmmppob.kingspedia.com/' // isi domain anda : https://domain.com/
	
);	
// date & time
$date = date("Y-m-d");
$time = date("H:i:s");
// date & time
$tanggal = date("Y-m-d");
$waktu = date("H:i:s");
require("lib/function.php");
// Logo Header //
$logo_header = "https://zaynflazz.com/smmpanel/assets/img/zaynflazz-golden.png";
?>

























