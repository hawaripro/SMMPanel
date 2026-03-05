<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
// WA GATEWAY //
$cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE id = '1'");
$data_wa_bot = $cek_wa->fetch_assoc();

// PROVIDER //
$cek_provider = $conn->query("SELECT * FROM provider WHERE code = 'ZAYNFLAZZ'");
$data_provider = $cek_provider->fetch_assoc();


if (isset($_POST['wagateway'])) {
    $tokenwa = $conn->real_escape_string($_POST['tokenwa']);
    $status = $conn->real_escape_string($_POST['status']);

    if (!$tokenwa || !$status) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Input Wa Gateway Tidak Boleh Kosong');
    } else {
        if ($conn->query("UPDATE bot_whatsapp SET token_wa = '$tokenwa', status = '$status' WHERE id = '1'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Wa Gateway Berhasil Di Update');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Wa Gateway Error.');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['provider'])) {
    $apikey = $conn->real_escape_string($_POST['apikey']);
    $profit = $conn->real_escape_string($_POST['profit']);

    if (!$apikey || !$profit) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Input Apikey/Profit Tidak Boleh Kosong');
    } else {
        if ($conn->query("UPDATE provider SET api_key = '$apikey', profit = '$profit' WHERE code = 'ZAYNFLAZZ'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Provider Berhasil Di Update');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Provider Error.');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['web'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $title = $conn->real_escape_string($_POST['title']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $keyword = $conn->real_escape_string($_POST['keyword']);
    $nomer = $conn->real_escape_string($_POST['nomer']);
    $facebook = $conn->real_escape_string($_POST['facebook']);
    $instagram = $conn->real_escape_string($_POST['instagram']);
    $twitter = $conn->real_escape_string($_POST['twitter']);
    $email = $conn->real_escape_string($_POST['email']);

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $nama_favicon = $_FILES['logo_1']['name'];
    $x = explode('.', $nama_favicon);
    $ekstensi = strtolower(end($x));
    $ukuran    = $_FILES['logo_1']['size'];
    $file_tmp = $_FILES['logo_1']['tmp_name'];

    $nama2 = $_FILES['logo_2']['name'];
    $x2 = explode('.', $nama2);
    $ekstensi2 = strtolower(end($x2));
    $ukuran2 = $_FILES['logo_2']['size'];
    $file_tmp2 = $_FILES['logo_2']['tmp_name'];
    if (!$nama || !$title || !$deskripsi || !$keyword || !$nomer || !$email) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Input Yang Wajib Di Isi Untuk Updated <br>
            - Nama<br>
            - Title<br>
            - Deskripsi<br>
            - Keyword<br>
            - Nomer Kontak<br>
            - Email<br>
            ');
    } else {
        $acakin = rand(1, 99999999);
        $acakin2 = rand(1, 99999999);
        if ($conn->query("UPDATE setting_web SET short_title = '$nama', title = '$title', deskripsi_web = '$deskripsi', keyword = '$keyword', wa_number = '$nomer', facebook_akun = '$facebook', ig_akun = '$instagram', twitter = '$twitter', email_akun = '$email' WHERE id = '1'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Website Berhasil Di Update');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Website Error.');
                }
        if (in_array($ekstensi or $ekstensi2, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070 and $nama_favicon == true) {
                move_uploaded_file($file_tmp, '../assets/images/favicon/' . $acakin . $nama_favicon);
                 if ($conn->query("UPDATE setting_web SET favicon = '$acakin$nama_favicon' WHERE id = '1'") == true) {
                     $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Website Berhasil Di Update');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Website Error.');
                }
            } else if($ukuran2 < 1044070 AND $nama2 == true){
                 move_uploaded_file($file_tmp2, '../assets/images/header-logo/' . $acakin2.$nama2);
                 if ($conn->query("UPDATE setting_web SET header_logo = '$acakin2$nama2' WHERE id = '1'") == true) {
                     $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Website Berhasil Di Update');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Website Error.');
                }
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Ukuran File Terlalu Besar.');
            }
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['payment_gateway'])) {
    $apikey = $conn->real_escape_string($_POST['apikey']);
    $secretkey = $conn->real_escape_string($_POST['secretkey']);
    $link = $conn->real_escape_string($_POST['link']);

    if (!$apikey || !$secretkey || !$link) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Input Apikey/Secret_key/Link Tidak Boleh Kosong');
    } else {
        if ($conn->query("UPDATE yabgroup SET api_key = '$apikey', secret_key = '$secretkey', link = '$link' WHERE id = '1'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Payment Gateway Berhasil Di Update');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Payment Gateway Error.');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['ehost'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    if (!$username || !$password) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Input username/password Tidak Boleh Kosong');
    } else {
        if ($conn->query("UPDATE email_hosting SET username = '$username', password = '$password' WHERE id = '1'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Email Hosting Berhasil Di Update');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Email Hosting Error.');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
}
require '../lib/header_admin.php';
?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Pengaturan </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/configurasi">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Website</li>
            </ol>
        </nav>
    </div>
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
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Settings Wa Gateway</h4>
                    <p class="card-description">Silahkan Daftar Wa Gateway <a href="https://fonnte.com" target="_blank">DISINI</a></p>
                    <form class="forms-sample" method="POST">
                        <div class="form-group row">
                            <label for="tokenwa" class="col-sm-3 col-form-label">Token</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tokenwa" name="tokenwa" value="<?php echo $data_wa_bot['token_wa']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="status">
                                    <option value="<?php echo $data_wa_bot['status']; ?>"><?php echo $data_wa_bot['status']; ?></option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                    <option value="Aktif">Aktif</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="wagateway" class="btn btn-info btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Settings Provider <button data-toggle="modal" data-target="#exampleModalLong4" class="btn btn-info btn-icon-text"><i class="mdi mdi-bell-ring"></i></button></h4>
                    <p class="card-description">Silahkan Daftar Provider <a href="https://zaynflazz.com" target="_blank">DISINI</a></p>
                    <form class="forms-sample" method="POST">
                        <div class="form-group row">
                            <label for="apikey" class="col-sm-3 col-form-label">Api_key</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="apikey" name="apikey" value="<?php echo $data_provider['api_key']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="profit" class="col-sm-3 col-form-label">Profit</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="profit" name="profit" value="<?php echo $data_provider['profit']; ?>">
                            </div>
                        </div>
                        <button type="submit" name="provider" class="btn btn-info btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Setting Informasi Websites</h4>
                    <form class="forms-sample" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nama">Nama Website</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['short_title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Informasi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?php echo $data['deskripsi_web']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="keyword">Keyword</label>
                            <textarea class="form-control" id="keyword" name="keyword" rows="4"><?php echo $data['keyword']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nomer">Kontak/Watsapp</label>
                            <input type="number" class="form-control" id="nomer" name="nomer" value="<?php echo $data['wa_number']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook Username</label>
                            <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $data['facebook_akun']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="instagram">Instagram Username</label>
                            <input type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $data['ig_akun']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter Username</label>
                            <input type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $data['twitter']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $data['email_akun']; ?>">
                        </div>
                        <div class="form-group">
                            <img class="img-fluid" src="/assets/images/favicon/<?php echo $data['favicon']; ?>" width="80" height="80">
                        </div>
                        <div class="form-group">
                            <label>Favicon Logo</label>
                            <input type="file" name="logo_1" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <img class="img-fluid" src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" width="80" height="80">
                        </div>
                        <div class="form-group">
                            <label>Header Logo</label>
                            <input type="file" name="logo_2" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                        <button type="submit" name="web" class="btn btn-info btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">PAYMENT GATEWAY DEPOSIT</h4>
                    <p class="card-description">Silahkan Daftar Payment gateway <a href="https://yab-group.com" target="_blank">DISINI</a></p>
                    <form class="forms-sample" method="POST">
                    <div class="form-group">
                        <label>Api_key</label>
                        <input type="text" class="form-control form-control-sm" name="apikey" id="apikey" value="<?php echo $data_Pgateway['api_key'];?>">
                    </div>
                    <div class="form-group">
                        <label>Secret_key</label>
                        <input type="text" class="form-control form-control-sm" name="secretkey" id="secretkey" value="<?php echo $data_Pgateway['secret_key'];?>">
                    </div>
                    <div class="form-group">
                        <label>link Mode</label>
                        <input type="text" class="form-control form-control-sm" name="link" id="link" value="<?php echo $data_Pgateway['link'];?>">
                    </div>
                    <button type="submit" name="payment_gateway" class="btn btn-info btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">EMAIL HOSTING</h4>
                    <form class="forms-sample" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control form-control-sm" name="username" id="username" value="<?php echo $data_hosting['username'];?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" class="form-control form-control-sm" name="password" id="password" value="<?php echo $data_hosting['password'];?>">
                    </div>
                    <div class="form-group">
                    <code>Masukan email hosting username dan password guna mengirim notifikasi risset sandi/password yang di kirim ke email member.</code>
                    </div>
                    <button type="submit" name="ehost" class="btn btn-info btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->
<!--MODAL-->
<div class="modal fade" id="exampleModalLong4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cara Seting Rate/Profit Layanan</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>1 = Menjual Produk Layanan Dengan Harga Provider/ Profit 0%</li>
                    <li>1.05 = Menjual Produk Layanan Dengan Harga Lebih tinggi 5% Dari Provider/ Profit Keuntungan Bersih 5% Dari Total jumlah Pemesanan</li>
                    <li>1.1 = Menjual Produk Layanan Dengan Harga Lebih tinggi 10% Dari Provider/ Profit Keuntungan Bersih 10% Dari Total jumlah Pemesanan</li>
                    <li>1.2 = Menjual Produk Layanan Dengan Harga Lebih tinggi 20% Dari Provider/ Profit Keuntungan Bersih 20% Dari Total jumlah Pemesanan</li>
                    <li>2 = Menjual Produk Layanan Dengan Harga Lebih tinggi 100% Dari Provider/ Profit Keuntungan Bersih 100% Dari Total jumlah Pemesanan</li>
                    <li>SESUAIKAN KEUNTUNGAN/PROFIT SESUAI KEINGINAN ANDA!</li>
                    <li><code>Setelah Profit Di Perbaharui Harap Updated Layanan Anda Agar Harga Berubah Sesuai Profit Terbaru pada halaman/menu kelola produk- ( kelola layanan ).</code></li>
                </ul>
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
require '../lib/footer_admin.php';
?>