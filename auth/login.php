<?php
session_start();
require '../config.php';

if (isset($_SESSION['user'])) {
    header("Location: ".$config['web']['url']);
} else {
    if (isset($_POST['login'])) {
        $post_username = $conn->real_escape_string(trim(filter($_POST['username'])));
        $post_password = $conn->real_escape_string(trim(filter($_POST['password'])));

        $check_user = $conn->query("SELECT * FROM users WHERE username = '$post_username' OR email = '$post_username' OR nomer = '$post_username'");
        $check_user_rows = mysqli_num_rows($check_user);
        $data_user = mysqli_fetch_assoc($check_user);

        $verif_pass = password_verify($post_password, $data_user['password']);

        if (!$post_username || !$post_password) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => '*Isi semua form input.');
        } else if ($check_user_rows == 0) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => '*Pengguna Tidak Tersedia.');
        } else if ($data_user['status'] == "Tidak Aktif") {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => '*Akun non aktif hubungi silahkan admin.');
        } else {
            if ($check_user_rows == 1) {
                if ($verif_pass == true) {
                    $conn->query("INSERT INTO log VALUES ('','$post_username', 'Login', '" . get_client_ip() . "','$date','$time')");
                    $_SESSION['user'] = $data_user;
                    exit(header("Location: " . $config['web']['url']));
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => '*Username/Password Invalid.');
                }
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
    }
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
                <h3 class="card-title text-left mb-3">Silahkan Masuk</h3>
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
                    <label>Username/email/phone</label>
                    <input type="text" name="username" id="username" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control p_input">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="/auth/lupa-password" class="forgot-pass">Lupa password</a>
                  </div>
                  <div class="text-center">
                    <button type="submit" name="login" class="btn btn-primary btn-block enter-btn">MASUK</button>
                  </div>
                  <p class="sign-up">Belum punya akun?<a href="/auth/register"> Daftar</a></p>
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