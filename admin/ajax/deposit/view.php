<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!isset($_SESSION['user']) || $data_user['level'] == "Member" || $data_user['level'] == "Reseller") {
        exit("Anda Tidak Memiliki Akses!");
    }
    if (!isset($_GET['id_deposit'])) {
        exit("Anda Tidak Memiliki Akses!-");
    }
    $get_id = $conn->real_escape_string(filter($_GET['id_deposit']));
    $cek_pengguna = $conn->query("SELECT * FROM deposit WHERE id = '$get_id'");
    while ($data_depo = $cek_pengguna->fetch_assoc()) {
        if ($data_depo['status'] == "Pending") {
            $label = "warning";
        } else if ($data_depo['status'] == "Success") {
            $label = "success";
        } else if ($data_depo['status'] == "Error") {
            $label = "danger";
        }

?>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-box">
                            <tr>
                                <th class="table-detail" width="50%">ID</th>
                                <td class="table-detail"><?php echo $data_depo['id']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail" width="50%">Deposit ID</th>
                                <td class="table-detail"><?php echo $data_depo['kode_deposit']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail" width="50%">Merchant_ref</th>
                                <td class="table-detail"><?php echo $data_depo['merchant_ref']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Username</th>
                                <td class="table-detail">
                                    <div class="text-primary"><?php echo $data_depo['username']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-detail">Provider</th>
                                <td class="table-detail"><?php echo $data_depo['provider']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Pembayaran</th>
                                <td class="table-detail"><?php echo $data_depo['payment']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Metode</th>
                                <td class="table-detail"><?php echo $data_depo['place_from']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Tujuan</th>
                                <td class="table-detail"><?php echo $data_depo['tujuan']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Jumlah Transfer</th>
                                <td class="table-detail">Rp <?php echo number_format($data_depo['jumlah_transfer'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Saldo Diterima</th>
                                <td class="table-detail">Rp <?php echo number_format($data_depo['get_saldo'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">STATUS</th>
                                <td class="table-detail"><span>
                                        <div class="badge badge-<?php echo $label; ?>"><?php echo $data_depo['status']; ?></div>
                                    </span></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Waktu & Tanggal</th>
                                <td class="table-detail"><?php echo tanggal_indo($data_depo['date']); ?>, <?php echo $data_depo['time']; ?> WIB</td>
                            </tr>
                        </table>
                    </div>

                </form>
            </div>
        </div>
<?php
    }
} else {
    exit("Anda Tidak Memiliki Akses!?");
}
