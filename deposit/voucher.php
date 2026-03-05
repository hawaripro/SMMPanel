<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
if (isset($_POST['request'])) {
    require '../lib/session_login.php';
    $post_voucher = $conn->real_escape_string(trim(filter($_POST['voucher'])));

    $cek_voucher = $conn->query("SELECT * FROM voucher_deposit WHERE voucher = '$post_voucher'");
    $data_voucher = $cek_voucher->fetch_assoc();
    $cek_voucher_rows = mysqli_num_rows($cek_voucher);

    $post_balance = $data_voucher['saldo'];
    $post_voc = $data_voucher['voucher'];
    
    $cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE status = 'Aktif'");
        $data_wa_bot = $cek_wa->fetch_assoc();
        
    if (!$post_voucher) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Mohon mengisi input');
    } else if ($cek_voucher_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Kode Voucher Tidak Valid.');
    } else if ($data_voucher['status'] == "sudah di redeem") {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Kode Voucher sudah di gunakan');
    } else {

        $kode = acak_nomor(3) . acak_nomor(3);

        $insert_depo = $conn->query("UPDATE voucher_deposit set status = 'sudah di redeem', user = '$sess_username', date = '$date', time = '$time' WHERE voucher = '$post_voucher'");
        $insert_depo = $conn->query("INSERT INTO deposit VALUES (NULL,'VC-$kode','-', '$sess_username', 'VOUCHER', 'redeem voucher' ,'voucher deposit Rp $post_balance', '-','-','$post_balance','$post_balance', 'Success', 'MANUAL','-', '$date', '$time')");
        $insert_depo = $conn->query("INSERT INTO history_saldo VALUES ('', '$sess_username', 'Penambahan Saldo', '$post_balance', 'Penambahan Saldo Dengan Voucher Deposit $post_balance', '$date', '$time')");
        $insert_depo = $conn->query("UPDATE users set saldo = saldo + $post_balance WHERE username = '$sess_username'");

        if ($insert_depo == TRUE) {
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
                        'message' => "REDEEM VOUCHER BERHASIL\n\nAnda baru saja melakukan deposit voucher sebesar : Rp $post_balance\nWaktu : $waktu_order - $time WIB\n\nby : $webstes",
                    ),
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: $token_whatsapp " //change TOKEN to your actual token
                    ),
                ));
    
                $response = curl_exec($curl);
                curl_close($curl);
                
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Redeem Voucher Berhasil', 'pesan' => 'Saldo Anda Telah Kami Tambah Dengan Nominal Rp ' . $post_balance);
            exit(header("location: " . $config['web']['url']));
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Upss', 'pesan' => 'Terjadi Kesalahan Silahkan Hubungi Admin');
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
                    <h4 class="card-title">- DEPOSIT VOUCHER</h4>
                    <form class="forms-sample" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                        <div class="form-group">
                            <label for="target">Masukan Kode Voucher</label>
                            <input type="text" name="voucher" id="voucher" class="form-control" style="background: #000;">
                        </div>
                        <button type="submit" name="request" class="btn btn-info float-right">Redeem</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">- LANGKAH - LANGKAH DEPOSIT VOUCHER</h4>
                    <ul>
                        <li>Pastikan anda sudah membeli<b> Kode Voucher Deposit </b>di Admin.</li>

                        <li>Masukkan kode voucher di bagian kolom kode voucher.</li>
                        <li>Klik Redeem, Kemudian tunggu hingga <span class="badge badge-success"> Success </span> saldo anda akan otomatis ditambahkan </li>
                    </ul>
                    <p><b>Keterangan</b> : Deposit ON 24 jam, Jika Terjadi Kendala Silahkan Hubungi Admin</p>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
require '../lib/footer.php';
?>