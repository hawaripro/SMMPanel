<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!isset($_SESSION['user']) || $data_user['level'] == "Member" || $data_user['level'] == "Reseller") {
    }
    if (!isset($_GET['id'])) {
        exit("Anda Tidak Memiliki Akses!");
    }
    $GetID = $conn->real_escape_string(filter($_GET['id']));
    $Check = $conn->query("SELECT * FROM tiket WHERE id = '$GetID'");
    $ThisData = $Check->fetch_assoc();
    if (mysqli_num_rows($Check) == 0) {
        exit("Data Tidak Ditemukan");
    } else {
?>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID Tiket</label>
                        <div class="col-sm-9">
                        <input type="number" name="id" class="form-control" value="<?php echo $ThisData['id']; ?>" readonly style="background: #000;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect w-md waves-light" name="delete">Hapus Tiket</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
} else {
    exit("Anda Tidak Memiliki Akses!");
}
