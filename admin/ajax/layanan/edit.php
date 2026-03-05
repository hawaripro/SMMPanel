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
    $get_idlayanan = $conn->real_escape_string(filter($_GET['id']));
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$get_idlayanan'");
    $data_layanan = $cek_layanan->fetch_assoc();
    if (mysqli_num_rows($cek_layanan) == 0) {
        exit("Data Tidak Ditemukan");
    } else {
?>
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                            <input type="text" name="id" class="form-control" value="<?php echo $data_layanan['id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Service ID</label>
                        <div class="col-sm-9">
                            <input type="text" name="service_id" class="form-control" value="<?php echo $data_layanan['service_id']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Provider ID</label>
                        <div class="col-sm-9">
                            <input type="text" name="provider_id" class="form-control" value="<?php echo $data_layanan['provider_id']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="kategori" id="kategori">
                                <option value="<?php echo $data_layanan['id_kategori']; ?>"><?php echo $data_layanan['kategori']; ?></option>
                                <?php
                                $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $data_kategori['id']; ?>"><?php echo $data_kategori['nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" name="layanan" class="form-control" value="<?php echo $data_layanan['layanan']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Catatan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="catatan"><?php echo $data_layanan['catatan']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                            <input type="number" name="harga" class="form-control" value="<?php echo $data_layanan['harga']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Min</label>
                        <div class="col-sm-9">
                            <input type="number" name="min" class="form-control" value="<?php echo $data_layanan['min']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Max</label>
                        <div class="col-sm-9">
                            <input type="number" name="max" class="form-control" value="<?php echo $data_layanan['max']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Refill<code>*jika bergaransi isi 1. jika tidak abaikan</code></label>
                        <div class="col-sm-9">
                            <input type="number" name="refill" class="form-control" value="<?php echo $data_layanan['refill']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status">
                                <option value="<?php echo $data_layanan['status']; ?>"><?php echo $data_layanan['status']; ?></option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Provider</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="provider" id="provider">
                                <?php
                                $cek_provider = $conn->query("SELECT * FROM provider");
                                while ($data_provider = $cek_provider->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $data_provider['code']; ?>"><?php echo $data_provider['code']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect w-md waves-light" name="update">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
} else {
    exit("Anda Tidak Memiliki Akses!");
}
