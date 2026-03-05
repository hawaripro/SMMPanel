<?php
session_start();
require("../config.php");
if (!isset($_SESSION['user'])) {
    die("Anda Tidak Memiliki Akses!");
}
if (isset($_POST['layanan'])) {
    $post_layanan = $conn->real_escape_string($_POST['layanan']);
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_layanan' AND status = 'Aktif'");
    $cek_diskon = $conn->query("SELECT * FROM users WHERE username = '" . $_SESSION['user']['username'] . "'");
    $data_diskon = mysqli_fetch_assoc($cek_diskon);

    if (mysqli_num_rows($cek_layanan) == 1) {
        $data_layanan = mysqli_fetch_assoc($cek_layanan);
        if ($data_layanan['refill'] == 1) {
            $garansi_refill = "YA";
        } else {
            $garansi_refill = "TIDAK";
        }
        if ($data_diskon['diskon_user'] == "0") {
            $price = $data_layanan['harga'];
        } else {
            $ST = (($data_layanan['harga'] * $data_diskon['diskon_user']) / 100);
            $price = $data_layanan['harga'] - $ST;
        }
?>
        <div class="alert alert-warning" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span><?= nl2br($data_layanan['catatan']); ?></span><br />
            <hr>
            <b class="text-danger">Harga/1K :</b> Rp <?php echo number_format($price, 0, ',', '.'); ?> <br />
            <b class="text-danger">Min :</b> <?php echo $data_layanan['min']; ?><br />
            <b class="text-danger">Max :</b> <?php echo $data_layanan['max']; ?><br />
            <b class="text-danger">Garansi Refill ♻️ :</b> <?php echo $garansi_refill; ?><br />
            <b class="text-danger">Kecepatan rata-rata :</b> <?php echo $data_layanan['average']; ?>
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="mdi mdi-block-helper"></i>
            <b>Gagal :</b> Service Tidak Ditemukan
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
