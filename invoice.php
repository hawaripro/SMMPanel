<?php
session_start();
require 'config.php';
require 'lib/session_user.php';
require 'lib/session_login.php';

$cek_depo = $conn->query("SELECT * FROM deposit WHERE username = '$sess_username' AND status = 'Pending'");
$data_depo = $cek_depo->fetch_assoc();
$depo = $cek_depo->num_rows;

$id = $data_depo['id'];
$get_id = $data_depo['kode_deposit'];
$saldo = $data_depo['get_saldo'];
$username = $data_depo['username'];

    if ($depo == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Data Invoice Tidak Ditemukan', 'pesan' => 'Tidak Menemukan Data Tagihan Deposit / Deposit Pending.');
        exit(header("Location: " . $config['web']['url'] . ""));
    } else {
        if ($data_depo['status'] == "Pending") {
            $label = "warning";
        } else if ($data_depo['status'] == "Error") {
            $label = "danger";
        }
        if ($data_depo['status'] == "Pending") {
            $message = "Menunggu Pembayaran";
        } else if ($data_depo['status'] == "Error") {
            $message = "Permintaan Telah Di batalkan";
        }
        if ($data_depo['place_from'] == "MANUAL") {
            $hide = "hidden";
        } else {
            $hide = "";
        }
        if ($data_depo['tipe'] == "QRIS") {
            $image = $data_depo['link'];
            $T_QR = "";
            $TJ = "";
            $info_tujuan = "QRIS";
        } else if ($data_depo['tipe'] == "EMoney") {
            $image = "";
            $T_QR = "hidden";
            $TJ = "hidden";
            $info_tujuan = $data_depo['provider'];
        } else {
            $image = "";
            $T_QR = "hidden";
            $TJ = "";
            $info_tujuan = "";
        }

        if (isset($_POST['cancel'])) {

            if ($conn->query("UPDATE deposit SET status = 'Error'  WHERE id = '$id' AND kode_deposit = '$get_id' AND username = '$username'") == true) {

                $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil!', 'pesan' => 'Deposit Anda Telah Kami Batalkan');
                exit(header("location: " . $config['web']['url'] . ""));
            }
        }
    }

require 'lib/header.php';
?>
<style>
    hr.new1 {
        border-top: 5px dashed red;
    }
    img.qr {
            width: 100%;
            height: 100%;
        }
</style>
<div class="content-wrapper">

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <img src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" alt="logo" width="150px">
                        </div>
                        <div class="float-right">
                            <h4 style="margin-top: 10px;">Invoice ID: <?php echo $data_depo['kode_deposit']; ?></h4>
                        </div>
                    </div>
                    <hr class="new1">

                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <p class="font-weight-bold">Hello, <?php echo $sess_username; ?></p>
                                <p> Silahkan lakukan pembayaran sebelum 24Jam sejak faktur ini di buat. </p>
                            </address>
                        </div>
                        <div class="col-md-6">
                            <address class="text-white mt-3 text-md-right">
                                <p class="font-weight-bold"> Waktu : <?php echo tanggal_indo($data_depo['date']); ?> - <?php echo $data_depo['time']; ?> WIB</p>
                            </address>
                            <address class="mt-3 text-md-right">
                                <p class="font-weight-bold"> <span class="badge bg-<?php echo $label; ?>"><?php echo $message; ?></span> </p>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> METODE </th>
                                        <th> TUJUAN </th>
                                        <th> JUMLAH TRANSFER </th>
                                        <th> DITERIMA </th>
                                        <th> FEE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $data_depo['payment']; ?>
                                        </td>
                                        <td><span <?php echo $TJ;?>><?php echo $data_depo['tujuan']; ?></span></td>
                                        <td>
                                            Rp <?php echo number_format($data_depo['jumlah_transfer'], 0, ',', '.'); ?>
                                        </td>
                                        <td> Rp <?php echo number_format($data_depo['get_saldo'], 0, ',', '.'); ?> </td>
                                        <td><?php echo $data_depo['fee']; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">NOTE :</h4>
                    <p class="card-description"> Jika sudah transfer silahkan menunggu 5-15 menit, maka saldo Anda akan otomatis terisi.
                        Jika saldo tidak masuk dalam waktu yang di tentukan, silahkan hubungi admin.
                    </p>
                    <p class="lead"> Mohon transfer dengan jumlah <b class="text-success">Rp <?php echo number_format($data_depo['jumlah_transfer'], 0, ',', '.'); ?></b> tidak boleh kurang atau lebih agar bisa terbaca oleh System.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="template-demo">
                                <form method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <button class="btn btn-danger btn-icon-text" name="cancel"> Batalkan </button>
                                    <a href="<?php echo $data_depo['link']; ?>" class="btn btn-success btn-icon-text" <?php echo $hide;?>>Bayar</a>
                                </form>
                                <button class="btn btn-info btn-icon-text" data-toggle="modal" id="myBtn" data-target='#myDetailqris' <?php echo $T_QR;?>> Tampilkan Kode QR </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- end container-fluid -->

<!--MODAL-->
<div class="modal fade" id="myDetailqris">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SILAHKAN SCAN KODE QR :</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <img class="qr" src="<?php echo $data_depo['link']; ?>"><hr>
               <p>Jumlah Transfer : Rp <?php echo number_format($data_depo['jumlah_transfer'], 0, ',', '.'); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
require 'lib/footer.php';
?>