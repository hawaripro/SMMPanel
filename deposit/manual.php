<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
if (isset($_POST['request'])) {
	require '../lib/session_login.php';
		$post_provider = $conn->real_escape_string($_POST['provider']);
		$post_jumlah = $conn->real_escape_string(trim(filter($_POST['jumlah'])));
        $post_pengirim = $conn->real_escape_string(trim(filter($_POST['pengirim'])));
        
		$cek_metod = $conn->query("SELECT * FROM metode_depo WHERE id = '$post_provider'");
		$data_metod = $cek_metod->fetch_assoc();
		$cek_metod_rows = mysqli_num_rows($cek_metod);
		
		$cek_depo = $conn->query("SELECT * FROM deposit WHERE username = '$sess_username' AND status = 'Pending'");
		$data_depo = $cek_depo->fetch_assoc();
		$count_depo = mysqli_num_rows($cek_depo);
		
		$kode = acak_nomor(3).acak_nomor(3);
		$acakin = acak_nomor(2).acak_nomor(1);
        
        $cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE status = 'Aktif'");
        $data_wa_bot = $cek_wa->fetch_assoc();
        
        $panggil_QRIS = $conn->query("SELECT * FROM logo_qris WHERE id = '1'");
        $data_QRIS = $panggil_QRIS->fetch_assoc();

		if (!$post_provider || !$post_jumlah) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Harap Mengisi Semua Input');
			
		} else if ($cek_metod_rows == 0) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Metode Deposit Tidak Tersedia.');
			
		} else if ($count_depo >= 1) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Masih terdapat deposit yang berstatus pending, silahkan dibatalkan dulu permintaan isi saldo sebelumnya di menu riwayat deposit.');
		} else if ($post_jumlah < $data_metod['min']) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Minimal deposit Rp. '.$data_metod['min'].'.');	
		} else if ($post_jumlah > $data_metod['max']) {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Maksimal deposit Rp. '.$data_metod['max'].'.');		
			
	    } else {
	     
	        $metodnya = $data_metod['nama'];
	        $get_saldo = $post_jumlah * $data_metod['rate'];
	        $amount = $acakin + $get_saldo;
	        $reg = $acakin + $post_jumlah;
	        if ($data_metod['tipe'] == "QRIS") {
	            $nama_bank = "QRIS";
	            $Qris = "".$config['web']['url']."assets/images/qris/".$data_QRIS['link']."";
	        } else if($data_metod['tipe'] == "Bank") {
	            $nama_bank = "BANK";
	            $Qris = "-";
	        } else if($data_metod['tipe'] == "E-Wallet") {
	            $nama_bank = "E-wallet";
	            $Qris = "-";
	        }
	        $insert = $conn->query("INSERT INTO deposit VALUES (NULL,'B-$kode', '-','$sess_username', '$nama_bank', '".$data_metod['provider']."' ,'".$data_metod['nama']."', '0','".$data_metod['tujuan']."','$reg', '$amount', 'Pending', 'MANUAL', '$Qris', '$date', '$time')");
	        
	        if ($insert == TRUE) {
                $target = $data_user['nomer'];
                $token_whatsapp =  $data_wa_bot['token_wa'];
                $waktu_order = (tanggal_indo($date));
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
                        'message' => "INVOICE DEPOSIT MANUAL\n\nID DEPOSIT : B-$kode\nTanggal & Waktu : $waktu_order - $time WIB\nTujuan : " . $data_metod['tujuan'] . "\nJumlah Transfer : $reg\nDiterima : $amount\nStatus : Pending\n\nby : $webstes",
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: $token_whatsapp " //change TOKEN to your actual token
                    ),
                ));
    
                $response = curl_exec($curl);
                curl_close($curl);
              
              exit(header("Location: ".$config['web']['url']."invoice.php")); 

	        } else {
			$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Error System(Insert To Database).');
	        }
	    }
	    header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
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
                            <h4 class="card-title">- DEPOSIT BARU</h4>
                            <form class="forms-sample" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>" >
                                <div class="form-group">
                                    <label>Pilih Metode Pembayaran</label>
                                    <select class="js-example-basic-single" name="provider" id="provider" style="width:100%">
                                        <option value="">Pilih Pembayaran</option>
                                        <?php
                                        $cek_pembayaran = $conn->query("SELECT * FROM metode_depo WHERE status = 'ON'");
                                        while ($data_pembayaran = $cek_pembayaran->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $data_pembayaran['id']; ?>"><?php echo $data_pembayaran['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div id="catatandepo"></div>
                                </div>
                                <div class="form-group">
                                    <label for="target">Jumlah</label>
                                    <input type="text" name="jumlah" id="jumlah" class="form-control" style="background: #000;">
                                </div>
                                <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Saldo Didapat</span>
                                            </div>
                                            <input type="text" class="form-control" id="ratemanual" readonly style="background: #000;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">IDR</span>
                                            </div>
                                        </div>
                                    </div>
                                <button type="submit" name="request" class="btn btn-info float-right">Konfirmasi</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">- LANGKAH - LANGKAH MELAKUKAN DEPOSIT</h4>
                            <ul>
                                <li>pilih salah satu pembayaran deposit.</li>
                                <li>masukkan jumlah yang akan kamu transfer Dan Nanti Akan Di Tambah 3 Kode Unik Contoh 10.000 + (156) Maka Kamu Harus Transfer Nominal + kode unik Tadi Sebesar 10.156.</li>
                                <li>Jika saldo di dapat tidak muncul silahkan klik saja pada kolom input saldo di dapat untuk menampilkan saldo yang di dapatkan </li>
                                <li>Klik Deposit Proses.</li>
                                <li>Setelah anda transfer sesuai invoice silahkan klik konfirmasi, saldo akan otomatis masuk ke akun anda.</li>
                                <li>JANGAN TRANSFER SEBELUM REQUEST DEPOSIT. TRANSFER HARUS SESUAI NOMINAL UNIK, JANGAN DIBULATKAN</li>
                                <li>Jika mengalamai kendala saat melakukan deposit bisa hubungi admin melalui tiket/kontak</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    require '../lib/footer.php';
    ?>