<?php
session_start();
require '../config.php';
if (isset($_POST['id'])) {
    $post_id = $conn->real_escape_string($_POST['id']);
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$post_id'");
    while ($data_layanan = $cek_layanan->fetch_assoc()) {
        if ($data_layanan['refill'] == "1") {
            $badge = "info";
            $info = "Refill";
        } else {
            $badge = "danger";
            $info = "X";
        }
?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-box">
                <tr>
                    <th class="table-detail" width="50%">ID</th>
                    <td class="table-detail"><?php echo $data_layanan['service_id']; ?></td>
                </tr>
                <tr>
                    <th class="table-detail">Layanan</th>
                    <td class="table-detail"><?php echo $data_layanan['layanan']; ?></td>
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
                    <td class="table-detail">
                        <badge class="badge badge-outline-<?php echo $badge; ?>"><?php echo $info; ?></badge>
                    </td>
                </tr>
                <tr>
                    <th class="table-detail">Catatan</th>
                    <td class="table-detail"><?= nl2br($data_layanan['catatan']); ?></td>
                </tr>
            </table>
        </div>
<?php
    }
}
?>