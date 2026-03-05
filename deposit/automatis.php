<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
if (isset($_POST['request'])) {
    require '../lib/session_login.php';
    $post_provider = $conn->real_escape_string($_POST['providerauto']);
    $post_jumlah = $conn->real_escape_string(trim(filter($_POST['jumlah'])));

    $cek_metod = $conn->query("SELECT * FROM metode_depo1 WHERE id = '$post_provider'");
    $data_metod = $cek_metod->fetch_assoc();
    $cek_metod_rows = mysqli_num_rows($cek_metod);

    $cek_depo = $conn->query("SELECT * FROM deposit WHERE username = '$sess_username' AND status = 'Pending'");
    $data_depo = $cek_depo->fetch_assoc();
    $count_depo = mysqli_num_rows($cek_depo);

    $kode = acak_nomor(3) . acak_nomor(3);
    $acakin = acak_nomor(2) . acak_nomor(1);

    $cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE status = 'Aktif'");
    $data_wa_bot = $cek_wa->fetch_assoc();

    if (!$post_provider || !$post_jumlah) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Harap Mengisi Semua Input');
    } else if ($cek_metod_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Metode Deposit Tidak Tersedia.');
    } else if ($count_depo >= 1) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Masih terdapat deposit yang berstatus pending, silahkan dibatalkan dulu permintaan isi saldo sebelumnya di menu riwayat deposit.');
    } else if ($post_jumlah < $data_metod['minimal_deposit']) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Minimal deposit Rp. ' . $data_metod['minimal_deposit'] . '.');
    } else if ($post_jumlah > $data_metod['maksimal_deposit']) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Maksimal deposit Rp. ' . $data_metod['maksimal_deposit'] . '.');
    } else {
        $nama_bank = $data_metod['tipe'];
        $metodnya = $data_metod['nama'];
        $get_saldo = $post_jumlah * $data_metod['rate'];
        $amount = $acakin + $get_saldo;
        $reg = $acakin + $post_jumlah;
        $cek_yab = $conn->query("SELECT * FROM yabgroup WHERE nama = 'YABGROUP'");
        $yabgroup = $cek_yab->fetch_assoc();
        $apiKey = $yabgroup['api_key'];
        $secretKey = $yabgroup['secret_key'];
        $method = $data_metod['provider'];
        $merchantRef = rand(1, 999999999);

        $url = $yabgroup['link'];

        $postdata = [
            'api_key'  => $apiKey,
            'secret_key'  => $secretKey,
            'channel_payment' => $method,
            'ref_kode' => $merchantRef,
            'nominal' => $reg,
            'cus_nama' => $sess_username,
            'url_redirect' => "" . $config['web']['url'] . "invoice.php",
            'url_callback' => "" . $config['web']['url'] . "cronsjob/callback_yab.php",
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature' => hash_hmac('sha256', $merchantRef . $apiKey . $reg, $secretKey)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if ($response['data']['status'] == "success") {
            $checkout_url = $response['data']['checkout_url'];
            $kode = $response['data']['id_reference'];
            $reg = $reg + $response['data']['fee'];
            $fee = $response['data']['fee'];
            $tujuan = $response['data']['target'];

            $insert = $conn->query("INSERT INTO deposit VALUES (NULL,'$merchantRef', '$kode','$sess_username', '$nama_bank', '" . $data_metod['provider'] . "' ,'" . $data_metod['nama'] . "', '$fee','$tujuan','$reg', '$amount', 'Pending', 'AUTOMATIS', '$checkout_url', '$date', '$time')");
            if ($insert == TRUE) {
                if ($data_metod['tipe'] == "EMoney") {
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
                            'message' => "INVOICE DEPOSIT AUTOMATIS\n\nID DEPOSIT : $merchantRef\nMetode : $metodnya\nTanggal & Waktu : $waktu_order - $time WIB\nTujuan : $tujuan\nJumlah Transfer : $reg\nDiterima : $amount\nStatus : Pending\n\nby : $webstes",
                        ),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: $token_whatsapp " //change TOKEN to your actual token
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    exit(header("Location: " . $checkout_url));
                } else {
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
                            'message' => "INVOICE DEPOSIT AUTOMATIS\n\nID DEPOSIT : $merchantRef\nMetode : $metodnya\nTanggal & Waktu : $waktu_order - $time WIB\nTujuan : $tujuan\nJumlah Transfer : $reg\nDiterima : $amount\nStatus : Pending\n\nby : $webstes",
                        ),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: $token_whatsapp " //change TOKEN to your actual token
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                    exit(header("Location: " . $config['web']['url'] . "invoice.php"));
                }
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Error System(Insert To Database).');
            }
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Permintaan Gagal', 'pesan' => 'Silahkan Coba lagi Nanti');
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
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                        <div class="form-group">
                            <label>Pilih Metode Pembayaran</label>
                            <select class="js-example-basic-single" name="providerauto" id="providerauto" style="width:100%">
                                <option value="">Pilih Pembayaran</option>
                                <?php
                                $cek_pembayaran = $conn->query("SELECT * FROM metode_depo1 WHERE keterangan = 'ON' ORDER BY tipe ASC");
                                while ($data_pembayaran = $cek_pembayaran->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $data_pembayaran['id']; ?>"><?php echo $data_pembayaran['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div id="catatandepoauto"></div>
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
                                <input type="text" class="form-control" id="rateauto" readonly style="background: #000;">
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