<?php
session_start();
require("../config.php");
$E_hosting = $conn->query("SELECT * FROM email_hosting WHERE id = '1'");
$data_hosting = $E_hosting->fetch_assoc();
$panggil = $conn->query("SELECT * FROM setting_web WHERE id = '1'");
$data = $panggil->fetch_assoc();
if (isset($_POST['ubahpw'])) {
    $PostUsername = $conn->real_escape_string(filter(trim($_POST['username'])));

    $cek_username = $conn->query("SELECT * FROM users WHERE username = '$PostUsername'");
    $user = $cek_username->fetch_assoc();

    $PostEmail = $conn->real_escape_string(filter(trim($_POST['email'])));

    $cek_email = $conn->query("SELECT * FROM users WHERE email = '$PostEmail'");
    $email = $cek_email->fetch_assoc();

    if (!$PostUsername || !$PostEmail) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Email/Username Tidak Terdaftar ');
    } else if ($cek_username->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username <strong>' . $username . ' </strong> Tidak Di Temukan');
    } else if ($cek_email->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Email <strong>' . $email . ' </strong> Tidak Di Temukan');
    } else {

        $acakin_password = acak(3) . acak_nomor(5);
        $hash_pass = password_hash($acakin_password, PASSWORD_DEFAULT);
        $tujuan = $user['email'];
        $pesannya = "
    
<p> Hi " . $user['nama'] . ",</p><br/>

<p> Anda telah melakukan permohonan reset password untuk akun " . $user['email'] . " </p>

<p> Silahkan salin password sementara ini untuk mengakses akun <b> " . $data['short_title'] . "</b> anda dan kemudian anda bisa mengatur ulang kata sandi di menu pengaturan.</p>

<br/>
<br/>
<hr>
<p>
<b> Username :</b> " . $user['username'] . "<br/>
<b> Password :</b> " . $acakin_password . "</p><br/>
<p>
<b> time :</b> " . $date . " " . $time . "<br/>
<b> IP address :</b> " . get_client_ip() . "<br/>
<b> browser :</b> " . $_SERVER['HTTP_USER_AGENT'] . "<br/>
</p>
<hr>
<br/>
<br/>
<br/>
<p> Mohon pastikan tidak ada karakter spasi di belakang username/password ketika melakukan copy-paste.</p><br/><br/>
<br/>
<br/>
<p><center><b>Team " . $data['short_title'] . "</b> </center></p>
<br/>
<br/>


";
        $subjek = "Reset Password";
        $header = "From:" . $data['short_title'] . "  " . $data_hosting['username'] . "\r\n";
        $header .= "Cc:" . $data_hosting['username'] . " \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $send = mail($tujuan, $subjek, $pesannya, $header);
        if ($conn->query("UPDATE users SET password = '$hash_pass', random_kode = '$acakin_password' WHERE username = '" . $user['username'] . "'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Reset Password Berhasil!', 'pesan' => 'Silahkan Cek Email/Folder Spam Anda Untuk Mengetahui Password Baru Anda');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Gagal');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
}
require '../lib/session_login.php';
require '../lib/database.php';
require '../lib/csrf_token.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo strtoupper($data['short_title']); ?> : <?php echo strtoupper($data['title']); ?></title>
    <meta name="description" content="<?php echo $data['deskripsi_web']; ?>">
    <meta name="keywords" content="<?php echo $data['keyword']; ?>">

    <!--ICON LOGO-->
    <link rel="shortcut icon" type="image/ico" href="/assets/images/favicon/<?php echo $data['favicon']; ?>" />
    <!--END ICON LOGO-->


    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Riset Password</h3>
                            <?php
                            if (isset($_SESSION['hasil'])) {
                            ?>
                                <div class="alert alert-dismissible alert-<?php echo $_SESSION['hasil']['alert'] ?> mb-3">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $_SESSION['hasil']['pesan'] ?>
                                </div>
                            <?php
                                unset($_SESSION['hasil']);
                            }
                            ?>
                            <form method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="username" id="username" class="form-control p_input">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control p_input">
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="ubahpw" class="btn btn-danger btn-block enter-btn">RISET</button>
                                </div>
                                <p class="sign-up">Saya ingin masuk?<a href="/auth/login"> Masuk</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <!-- endinject -->
</body>

</html>