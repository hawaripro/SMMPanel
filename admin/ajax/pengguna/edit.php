<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!isset($_SESSION['user']) || $data_user['level'] == "Member" || $data_user['level'] == "Reseller") {
        exit("Anda Tidak Memiliki Akses!");
    }
    if (!isset($_GET['id'])) {
        exit("Anda Tidak Memiliki Akses!");
    }
    $get_idpengguna = $conn->real_escape_string(filter($_GET['id']));
    $cek_pengguna = $conn->query("SELECT * FROM users WHERE id = '$get_idpengguna'");
    $data_pengguna = $cek_pengguna->fetch_assoc();
    if (mysqli_num_rows($cek_pengguna) == 0) {
        exit("Data Tidak Ditemukan");
    } else {
?>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID Users</label>
                        <div class="col-sm-9">
                            <input type="number" name="id" class="form-control" value="<?php echo $data_pengguna['id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Level</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="level">
                                <option value="<?php echo $data_pengguna['level']; ?>"><?php echo $data_pengguna['level']; ?></option>
                                <option value="Member">Member</option>
                                <option value="Reseller">Reseller</option>
                                <option value="Developers">Developers</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" value="<?php echo $data_pengguna['email']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" name="username" class="form-control" value="<?php echo $data_pengguna['username']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Password <small class="text-danger">*Kosongkan jika tidak diubah.</small></label>
                        <div class="col-sm-9">
                            <input type="text" name="password" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Saldo</label>
                        <div class="col-sm-9">
                            <input type="number" name="saldo" class="form-control" value="<?php echo $data_pengguna['saldo']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Discount<small class="text-danger">*discount harga custom untuk users 0=0%/5=5%/10=10% dari harga asli.</small></label>
                        <div class="col-sm-9">
                        <input type="number" name="diskon" class="form-control" value="<?php echo $data_pengguna['diskon_user']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"> Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status">
                                <option value="<?php echo $data_pengguna['status']; ?>"><?php echo $data_pengguna['status']; ?></option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect w-md waves-light" name="edit">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
} else {
    exit("Anda Tidak Memiliki Akses!");
}
