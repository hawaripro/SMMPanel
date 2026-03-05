<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!isset($_SESSION['user']) || $data_user['level'] == "Member" || $data_user['level'] == "Reseller") {
        exit("Anda Tidak Memiliki Akses!");
    }
    if (!isset($_GET['id'])) {
        exit("Anda Tidak Memiliki Akses!-");
    }
    $get_id = $conn->real_escape_string(filter($_GET['id']));
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$get_id'");
    while ($data_layanan = $cek_layanan->fetch_assoc()) {
        if ($data_layanan['status'] == "Aktif") {
            $label = "success";
        } else if ($data_layanan['status'] == "Tidak Aktif") {
            $label = "danger";
        }

?>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-box">
                            <tr>
                                <th class="table-detail" width="50%">ID Services</th>
                                <td class="table-detail"><?php echo $data_layanan['service_id']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">ID Provider</th>
                                <td class="table-detail">
                                    <div class="text-primary"><?php echo $data_layanan['provider_id']; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-detail">Kategori</th>
                                <td class="table-detail"><?php echo $data_layanan['kategori']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Layanan</th>
                                <td class="table-detail"><?php echo $data_layanan['layanan']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Catatan</th>
                                <td class="table-detail"><?= nl2br($data_layanan['catatan']); ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Average Time</th>
                                <td class="table-detail"><?php echo $data_layanan['average']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Harga</th>
                                <td class="table-detail">Rp <?php echo number_format($data_layanan['harga'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Min</th>
                                <td class="table-detail"><?php echo $data_layanan['min']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Max</th>
                                <td class="table-detail"><?php echo $data_layanan['max']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Refill</th>
                                <td class="table-detail"><?php echo $data_layanan['refill']; ?></td>
                            </tr>
                            <tr>
                                <th class="table-detail">STATUS</th>
                                <td class="table-detail"><span>
                                        <div class="badge badge-<?php echo $label; ?>"><?php echo $data_layanan['status']; ?></div>
                                    </span></td>
                            </tr>
                            <tr>
                                <th class="table-detail">Provider</th>
                                <td class="table-detail"><?php echo $data_layanan['provider']; ?></td>
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
