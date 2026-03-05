<?php
session_start();
require("../config.php");
if (!isset($_SESSION['user'])) {
    die("Anda Tidak Memiliki Akses!");
}
if (isset($_POST['providerauto'])) {
    $post_layanan = $conn->real_escape_string($_POST['providerauto']);
    $cek_layanan = $conn->query("SELECT * FROM metode_depo1 WHERE id = '$post_layanan'");
    if (mysqli_num_rows($cek_layanan) == 1) {
        $data_layanan = mysqli_fetch_assoc($cek_layanan);
        if($data_layanan['tipe'] == 'EMoney'){
            $F = "%";
            $fee = $data_layanan['fee'];
        } else {
            $F = "";
            $fee = $data_layanan['fee'];
        }
        if($data_layanan['provider'] == "QRIS"){
            $P = "+350";
        } else {
            $P = "";
        }
?>
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span>Payment : <?php echo $data_layanan['nama']; ?></span><br />
            <span>Silahkan Lanjutkan Pembayaran Masukan Jumlah Deposit Lalu Klik Konfirmasi.<br> ( selanjutnya anda akan di arahkan ke menu invoice dengan total jumlah pembayaran yang harus di bayar )</span><br />
            <hr> 
            <b class="text-danger">Fee :</b> <?php echo $fee; ?><?php echo $F; ?> <?php echo $P; ?><br />
            <b class="text-danger">Minimal deposit :</b> Rp <?php echo number_format($data_layanan['minimal_deposit'], 0, ',', '.'); ?><br />
            <b class="text-danger">Maksimal deposit :</b> Rp <?php echo number_format($data_layanan['maksimal_deposit'], 0, ',', '.'); ?><br />
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="mdi mdi-block-helper"></i>
            <b>Gagal :</b> Tidak Ditemukan
        </div>
    <?php
    }
} else {
    ?>
    <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <i class="mdi mdi-block-helper"></i>
        <b>Gagal : </b> Terjadi Kesalahan.
    </div>
<?php
}
