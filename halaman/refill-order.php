<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
$post_idtarget = $conn->real_escape_string($_GET['id']);
require '../lib/session_login.php';
$cek_refill = $conn->query("SELECT * FROM pembelian_sosmed WHERE id = '$post_idtarget' AND user = '$sess_username'");
$data_refil = $cek_refill->fetch_assoc();

$cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE status = 'Aktif'");
$data_wa_bot = $cek_wa->fetch_assoc();

$oid = $data_refil['oid'];
$data_target = $data_refil['target'];
$provider_oid = $data_refil['provider_oid'];
$cek_status = $data_refil['status'];
if($cek_status == "Success") {
    $badge = "success";
} else if ($cek_status == "Error") {
    $badge = "danger";
} else if ($cek_status == "Partial") {
    $badge = "danger";
} else if ($cek_status == "Processing") {
    $badge = "info";
} else if ($cek_status == "In Progress") {
    $badge = "info";
} else if ($cek_status == "Pending") {
    $badge = "warning";
} else {
   $badge = "info"; 
}

$cek_refill_ready = $conn->query("SELECT * FROM refill_order WHERE oid = '$oid' AND username = '$sess_username'");
$data_refil_ready = $cek_refill_ready->fetch_assoc();

$post_refill_ready = $data_refil_ready['oid'];


if (mysqli_num_rows($cek_refill) == 0) {
	$_SESSION['hasil'] = array('alert' => 'error', 'judul' => 'Permintaan Gagal', 'pesan' => 'Data Refill Tidak Ditemukan');
	exit(header("Location: ".$config['web']['url']."halaman/riwayat-order"));
} else {
    if (isset($_POST['refill_up'])) {
    require '../lib/session_login.php';
	$post_id = $provider_oid ;
	$post_layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
	
	$cek_layanan = $conn->query("SELECT * FROM pembelian_sosmed  WHERE provider_oid = '$post_id'");
	$data_layanan = mysqli_fetch_assoc($cek_layanan);
	$provider = $data_layanan['provider'];
	$cek_status = $data_layanan['status'];
	
	$cek_provider = $conn->query("SELECT * FROM provider WHERE code = 'ZAYNFLAZZ'");
	$data_provider = mysqli_fetch_assoc($cek_provider);

	$name_provider = $data_provider['code'];
	$url = $data_provider['link'];

	if (!$post_id || !$post_layanan) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Data Kosong Atau Tidak Di Ketahui');

	} else if (mysqli_num_rows($cek_provider) == 0) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Server Sedang Maintance #1.');
	} else if (mysqli_num_rows($cek_layanan) == 0) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Data Tidak Di Temukan.');
	} else if ($cek_status == "Pending") {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '(Pending) Tunggu Status Success / Minimal 2 Hari Setelah Status Berhasil/Success.');
	} else if ($cek_status == "Processing") {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '(Processing) Tunggu Status Success / Minimal 2 Hari Setelah Status Berhasil/Success.');
	} else if ($cek_status == "In Progress") {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '(In Progress) Tunggu Status Success / Minimal 2 Hari Setelah Status Berhasil/Success.');
	} else if ($cek_status == "Error") {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '(Error) Tidak Dapat Di Refill');
	} else if ($cek_status == "Partial") {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '(Partial) Tidak Dapat Di Refill');
	} else if ($oid == $post_refill_ready) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Pemesanan Gagal!', 'pesan' => 'Refill Sudah Di Ajukan Silahkan Cek Di Riwayat Refill.');
	} else {
	
	if ($provider == "MANUAL") {
			$api_postdata = "";
	} else if ($provider == $name_provider) {
	  $postdata = "api_key=" . $data_provider['api_key'] . "&action=refill&id_order=$post_id";
     $url = $url;
	} else {
		die("System Error 608!");
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$chresult = curl_exec($ch);
	curl_close($ch);
	$json_result = json_decode($chresult, true);
		if ($provider == $name_provider AND $json_result['data']['id_refill'] == false) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => ''.$json_result['data']['pesan'].' ');
		} else if ($provider == $name_provider2 AND $json_result['refill'] == false) {
		    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Order Gagal!', 'pesan' => 'Kesalahan / Refill Belum Dapat Di Terima #2');
		} else if ($provider == $name_provider3 AND $json_result['data']['id_refill'] == false) {
		    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Order Gagal!', 'pesan' => 'Kesalahan / Refill Belum Dapat Di Terima #3');
		} else {
			if ($provider == "MANUAL") {
				$post_id = $provider_oid;
			} else if ($provider == $name_provider) {
			    $post_id = $json_result['data']['id_refill'];
			}
			$update_at = date('Y-m-d H:i:s');
			
			if ($conn->query("INSERT INTO refill_order VALUES ('','$oid', '$post_id', '$sess_username', '$post_layanan', '$data_target', Pending','$update_at','$provider')") == true) {
			    
			    $target = $data_user['nomer'];
                $token_whatsapp =  $data_wa_bot['token_wa'];
                $waktu_order = $update_at;
                $webstes = $config['web']['url'];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $target,
                        'message' => "PENGAJUAN REFILL BERHASIL\n\nID ORDER: $oid\nTanggal & Waktu : $waktu_order WIB\nLayanan : $post_layanan\nTujuan : $data_target\nStatus : Pending\n\nby : $webstes",
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: $token_whatsapp " //change TOKEN to your actual token
                    ),
                ));
    
                $response = curl_exec($curl);
                curl_close($curl);

				$_SESSION['hasil'] = array(
					'alert' => 'success',
					'judul' => 'Refill Berhasil.',
					'pesan' => '<b>Order ID : </b> ' . $oid . '<br />
    				 - <b>Layanan : </b> ' . $post_layanan . '<br />
    				 '
				);
			} else {
				$_SESSION['hasil'] = array('alert' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Error System (2)');
			}
		}
		header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
	}
}
}
require '../lib/header.php';
?>
<div class="content-wrapper">
<?php
if (isset($_SESSION['hasil'])) {
?>
    <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <b><?php echo $_SESSION['hasil']['judul'] ?></b> <?php echo $_SESSION['hasil']['pesan'] ?>
    </div>
<?php
    unset($_SESSION['hasil']);
}
?>
              <div class="row">
                <div class="col-md-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">- REFILL UP <badge class="badge badge-<?php echo $badge; ?> float-right"><?php echo $data_refil['status']; ?></badge></h4>
                            <form class="forms-sample" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>" >
                                <div class="form-group">
                                    <label for="target">Order ID</label>
                                    <input type="text" class="form-control" value="<?php echo $data_refil['oid']; ?>" readonly style="background: #000;">
                                </div>
                                <div class="form-group">
                                    <label for="target">Layanan</label>
                                    <input type="text" name="layanan" class="form-control" value="<?php echo $data_refil['layanan']; ?>" readonly style="background: #000;">
                                </div>
                                <a href="/halaman/riwayat-order" class="btn btn-danger mr-2">Kembali</a>
                                <button type="submit" name="refill_up" class="btn btn-info float-right">Ajukan Refill</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">- KETENTUAN REFILL</h4>
                            <ul>
                                <li>Definisi refill adalah proses pengisian ulang layanan (followers / view / lainnya) yang mengalami drop atau penurunan sejak orderan completed/Success.</li>
                                <li>Refill hanya berlaku untuk layanan yang memberikan garansi refill. Setiap layanan memberikan masa garansi berbeda-beda (silahkan lihat dibagian diskripsi layanan).</li>
                                <li>Jika tombol refill tidak bekerja dalam 3 hari, Anda dapat membuat laporan refill secara manual melalui Tiket / WA Support kami.</li>
                                <li>Untuk layanan yang tidak memiliki label ♻️ atau tombol refill, silahkan buat laporan dengan cara kirimkan ID Pesanan refill Anda melalui tiket atau kontak kami.</li>
                                <li>Pesanan dengan status partial tidak dapat direfill.</li>
                                <li>Pesanan akan dapat direfill jika drop dibawah jumlah pesan.</li>
                                <li>Pesanan akan dapat direfill jika jaminan atau periode isi ulang masih berlaku dan belum expired.</li>
                                <li>Pesanan yang turun dibawah jumlah awal pada pesanan tidak dapat direfill, karena sudah dipastikan drop dari pesanan lama sehingga Anda bisa naikan terlebih dahulu pesanan target sampai berada diatas jumlah awal.</li>
                                <li>Jika Anda mengirim atau membuat laporan isi ulang pada saat periode jaminan isi ulang masih berlaku, dan pesanan Anda tidak terefill sampai periode jaminan isi ulang berakhir. Tidak ada pengembalian dana untuk kasus ini.</li>
                                <li>Pesanan yang ada dalam daftar laporan refill, akan dikirimkan setiap hari kepenyedia layanan untuk permintaan isi ulang sehingga kami tidak memiliki estimasi / jendela waktu kapan pesanan akan selesai direfill, semua pesanan yang ada dalam daftar laporan akan di konfirmasi seperti biasa jika pesanan sudah selesai refill. Kami bekerja sebaik mungkin untuk menyelesaikan seluruh pesanan serta mengisi ulang pesanan yang memiliki jaminan refill.</li>
                                <li>Apabila Anda memiliki banyak pesanan untuk target dan jenis layanan yang sama, maka refill hanya berlaku untuk pesanan terakhir yang ditempatkan.</li>
                            </ul>
                            <h4 class="card-title">NOTE :</h4>
                            <ul>
                                <li>Akun private = tidak bisa refill</li>
                                <li>Request Refill tidak dapat dilakukan jika waktu masa garansi telah habis. Sehingga komplain refill setelah expired tidak diterima.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    require '../lib/footer.php';
    ?>