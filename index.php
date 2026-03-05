<?php
session_start();
require("config.php");
if (!isset($_SESSION['user'])) {
    if (isset($_POST['login'])) {
        $post_username = $conn->real_escape_string(trim(filter($_POST['username'])));
        $post_password = $conn->real_escape_string(trim(filter($_POST['password'])));

        $check_user = $conn->query("SELECT * FROM users WHERE username = '$post_username' OR email = '$post_username' OR nomer = '$post_username'");
        $check_user_rows = mysqli_num_rows($check_user);
        $data_user = mysqli_fetch_assoc($check_user);

        $verif_pass = password_verify($post_password, $data_user['password']);

        if (!$post_username || !$post_password) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Isi semua form input.');
        } else if ($check_user_rows == 0) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Pengguna Tidak Tersedia.');
        } else if ($data_user['status'] == "Tidak Aktif") {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Akun non aktif hubungi silahkan admin.');
        } else {
            if ($check_user_rows == 1) {
                if ($verif_pass == true) {
                    $conn->query("INSERT INTO log VALUES ('','$post_username', 'Login', '" . get_client_ip() . "','$date','$time')");
                    $_SESSION['user'] = $data_user;
                    exit(header("Location: " . $config['web']['url']));
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username/Password Invalid.');
                }
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
    }
    require 'lib/header_landing.php';
?>
    <div class="wrapper-content">
        <div class="wrapper-content__header">
        </div>
        <div class="wrapper-content__body">
            <!-- Main variables *content* -->
            <div id="block_125">
                <div class="block-bg">
                    <div class="bg-image"></div>
                </div>
                <div class="block-divider-bottom"><svg width="100%" height="100%" viewBox="0 0 1280 140" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                            <path d="M1280 140V0S993.46 140 640 139 0 0 0 0v140z" />
                        </g>
                    </svg></div>
                <div class="container">
                    <div class="block-signin ">
                        <div class="row">
                            <div class="col">
                                <div class="block-signin__content">
                                    <div class="block-signin__title style-text-signin">
                                        <h1 class="text-center"><span style="text-align: CENTER"><span style="color: var(--color-id-231)">Smm Panel Indonesia</span></span></h1>
                                    </div>
                                    <div class="block-signin__description style-text-signin">
                                        <p class="text-center"><span style="color: var(--color-id-231)"><span style="text-align: CENTER"><?php echo $data['title']; ?></span></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="block-signin__card component_card">
                                    <div class="card">
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
                                        <form method="POST" class="component_form_group component_checkbox_remember_me">
                                            <div class="form-row">
                                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                                <div class="custom-col">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input class="form-control" type="text" name="username" id="username" />
                                                    </div>
                                                </div>
                                                <div class="custom-col">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input class="form-control" type="password" name="password" id="password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="sign-in__remember-me">
                                                        <div class="form-group__checkbox">
                                                            <label class="form-group__checkbox-label">
                                                                <input type="checkbox" name="remember" id="remember">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <label class="form-group__label-title" for="remember">Remember me</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="custom-col">
                                                    <div class="form-group ">
                                                        <div class="sign-in__forgot">
                                                            <a href="/auth/lupa-password">Lupa password?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="form-group d-flex component_button_submit ">
                                                        <button class="btn btn-big-primary" type="submit" name="login">MASUK</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="custom-col">
                                                    <div class="form-group d-flex justify-content-center ">
                                                        <div class="block-signin__remember">
                                                            <p>Belum punya akun?</p>
                                                            <a class="block-signin__link" href="/auth/register">Daftar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="block_116">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center">Kenapa Harus Di <b style="color:#00ff00;"><?php echo $data['short_title']; ?></b></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center">4 Alasan Kenapa Kamu Harus Memilih <?php echo $data['short_title']; ?>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_120">
                <div class="block-bg"></div>
                <div class="block-divider-bottom"><svg width="100%" height="100%" viewBox="0 0 1280 140" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                            <path d="M1280 140V0S993.46 140 640 139 0 0 0 0v140z" />
                        </g>
                    </svg></div>
                <div class="container">
                    <div class="block-features ">
                        <div class="row align-items-start justify-content-start">
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style=" height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-trophy-alt" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-244);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Kualitas Terjamin</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami memastikan layanan yang terbaik demi kenyamanan pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style=" height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-receipt" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-245);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Metode Pembayaran</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami menerima berbagai metode pembayaran untuk mempermudah pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="background:none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style="height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-hands-usd" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-246);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Harga Termurah</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Kami memberikan harga yang terbaik sesuai dengan kebutuhan pengguna.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 style-features-card">
                                <div class="w-100 editor__component-wrapper">
                                    <div class="card block-features__wrapper" style="
                     background: none;color: inherit;box-shadow: none;">
                                        <div class="features-card__preview">
                                            <div class="block-features__card-icon style-bg-primary-alpha-10 style-border-radius-default style-text-primary" style="height: 80px;width: 80px;font-size: 80px;background: var(--color-id-215);border-top-left-radius: 48px;border-bottom-left-radius: 48px;border-top-right-radius: 48px;border-bottom-right-radius: 48px;">
                                                <span class="styled-card-hover">
                                                    <span class="feature-block__icon style-text-primary fas fa-box-heart" style="width: 24px;height: 24px;transform: rotate(0deg);color: var(--color-id-247);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card features-card" style=" color: inherit; ">
                                            <div class="block-features__card">
                                                <div class="block-features__card-content">
                                                    <div class="card-content__head style-text-features-title" style="margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">
                                                        <p><strong style="font-weight: bold">Proses Pengiriman Cepat</strong></p>
                                                    </div>
                                                    <div class="card-content__desc style-text-features-desc" style="padding-left: 0px; padding-right: 0px;">
                                                        <p>Semua Orderan Atau Pesanan akan kami proses secepat mungkin.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_98">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center"><span style="text-align: CENTER">Cara Melakukan Pemesanan</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center"><span style="text-align: CENTER">4 Langkah Mudah Untuk Melakukan Pemesanan.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_100">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="how-it-works ">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-end">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-check-double" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-244);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            1
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Lakukan Pendaftaran Akun</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Mulai dengan melakukan pendaftaran di situs kami secara Gratis!</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-start">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-box-check" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-245);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            2
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Deposit Saldo</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Langkah selanjutnya adalah melakukan Deposit. Kami meberima pembayaran Transfer Bank dan E Wallet (Dana, OVO, Gopay, Shopepay) Virtual Account dan Qris</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-end">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;">
                                                            <span class="card__icon-fa far fa-user-circle" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-246);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            3
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Lakukan Pemesanan</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0x;">
                                                            <p>Pilih layanan sosial media yang ingin kamu pesan. Pastikan kamu menginput data yang benar.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                        <div class="how-it-works__card">
                                            <div class="card" style="background: none;color: inherit;box-shadow: none;">
                                                <div class="how-it-works__card-wrap">
                                                    <div class="card__icon" style="justify-content: flex-start">
                                                        <span class="card__icon-wrap" style="height: 80px;width: 80px;">
                                                            <span class="card__icon-fa far fa-user-check" style="font-size: 56px;width: 56px;height: 56px;transform: rotate(0deg);color: var(--color-id-247);text-shadow: Array;border-radius: 0px;background: none;padding: 0px;"></span>
                                                        </span>
                                                    </div>
                                                    <div class="card__number-wrap">
                                                        <div class="how-it-works-number style-box-shadow-default style-bg-light style-border-radius-50 style-card-number" style="width: 80px;height: 80px;background: var(--color-id-208);border-color: var(--color-id-218);border-top-left-radius: 50px;border-bottom-left-radius: 50px;border-top-right-radius: 50px;border-bottom-right-radius: 50px;border-left-width: 8px;border-right-width: 8px;border-bottom-width: 8px;border-top-width: 8px;border-style: solid;font-size: 24px;color: var(--color-id-228); ">
                                                            4
                                                        </div>
                                                    </div>
                                                    <div class="card__content">
                                                        <div class="content__title style-how-it-card-title" style="margin-bottom: 8px; padding-top: 0px; padding-left: 0px; padding-right: 0px;">
                                                            <p><strong style="font-weight: bold">Orderan Diproses</strong></p>
                                                        </div>
                                                        <div class="content__desc style-how-it-card-desc" style="padding-left: 0px; padding-right: 0px;">
                                                            <p>Orderan kamu akan diproses secara otomatis. Kamu dapat memantau statusnya di halaman riwayat.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="how-it-works__card-line style-card-number-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_97">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="reviews-block ">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="reviews-block__title style-review-card-title">
                                    <h2>Apa yang pelanggan kami katakan</h2>
                                </div>
                                <div class="reviews-block__desc style-review-card-desc">
                                    <p>Ingin tahu tentang pendapat pelanggan lain tentang panel kami? Simak beberapa ulasan mereka berikut ini.</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Tugas saya adalah membantu bisnis agar diperhatikan secara online dan membantu mereka menarik lebih banyak pelanggan dengan cara itu. Layanan SMM yang ditawarkan panel ini membantu saya bekerja lebih cepat!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Dimas Irawan - Member</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Panel SMM ini sungguh luar biasa dalam meningkatkan keterlibatan di akun media sosial Anda! Hal ini dapat dilakukan dengan cepat dan efektif tanpa mengeluarkan banyak uang. Faktanya, layanan di sini sangat murah, sungguh luar biasa!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Alika - Resellers</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Saya membantu berbagai bisnis untuk mendapatkan lebih banyak eksposur online dengan mengelola akun media sosial mereka. Izinkan saya memberi tahu Anda ini: Layanan SMM yang ditawarkan panel ini membantu saya menghemat banyak uang ekstra dan menghasilkan jauh lebih banyak daripada sebelum saya menemukan orang-orang ini.</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Ica Pratiwi - Member</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 co-sm-12">
                                        <div class="block-reviews__card">
                                            <div class="card card__reviews">
                                                <div class="item__desc style-review-card-desc" style="padding-left: 0px; padding-right: 0px; margin-bottom: 16px;">
                                                    <p>Memang tidak mudah untuk mendapatkan hasil engagement yang dibutuhkan untuk akun bisnis Anda, apalagi jika Anda masih pemula. Membayar agen SMM bisa menjadi terlalu mahal. Untungnya saya menemukan panel SMM ini, layanan yang saya cari sangat murah di sini!</p>
                                                </div>
                                                <div class="item__author style-review-card-author" style="padding-left: 0px; padding-right: 0px;">
                                                    <p><strong style="font-weight: bold">Yoga Saputra - Resellers</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_113">
                <div class="block-bg">
                    <div class="bg-image"></div>
                </div>
                <div class="container">
                    <div class="header-with-text ">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__title">
                                    <h2 class="text-center"><span style="text-align: CENTER">Pertanyaan yang sering ditanyakan :</span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-block__description">
                                    <p class="text-center"><span style="text-align: CENTER">Staf kami memilih beberapa pertanyaan yang paling sering diajukan tentang panel SMM dan menjawabnya.</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block_102">
                <div class="block-bg"></div>
                <div class="container">
                    <div class="faq ">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-1" aria-expanded="false" aria-controls="#faq-block-102-1">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Mengapa orang menggunakan panel SMM?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-1">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Panel SMM adalah toko online yang menjual layanan SMM dengan harga terjangkau.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-2" aria-expanded="false" aria-controls="#faq-block-102-2">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Jenis layanan SMM apa yang Anda jual di sini?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-2">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Kami menyediakan berbagai jenis layanan SMM: Followers, Subscriber, Likes , Views dll</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-3" aria-expanded="false" aria-controls="#faq-block-102-3">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah benar aman menggunakan layanan SMM di panel ini?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-3">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Ya, sepenuhnya aman, Anda tidak akan kehilangan akun media sosial Anda.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-4" aria-expanded="false" aria-controls="#faq-block-102-4">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah Layanan SMM Bergaransi?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-4">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Iya, kami memiliki layanan bergaransi dan no refill. Layanan ini berlabel Guaranteed (Bergaransi).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-5" aria-expanded="false" aria-controls="#faq-block-102-5">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Apakah Layanan SMM Ini Otomatis?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-5">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Layanan di sini sudah otomatis. Kamu bisa pantau status orderan di halaman riwayat order.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="faq-block__card">
                                    <div class="card">
                                        <div class="faq-block__header collapsed" data-toggle="collapse" data-target="#faq-block-102-6" aria-expanded="false" aria-controls="#faq-block-102-6">
                                            <div class="faq-block__header-title">
                                                <p><strong style="font-weight: bold">Bagaimana Jika Saya Ada Kendala?</strong></p>
                                            </div>
                                            <div class="faq-block__header-icon">
                                                <div class="style-text-dark faq-block__icon" style="color: var(--color-id-219);"></div>
                                            </div>
                                        </div>
                                        <div class="faq-block__body collapse" id="faq-block-102-6">
                                            <div class="faq-block__body-description" style="padding-top: 8px">
                                                <p>Jika Anda mengalami kendala saat menggunakan situs kami, kamu bisa langsung chat kami melalui Tiket atau WA. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    require 'lib/footer_landing.php';
} else {
    require 'lib/session_user.php';
    if (isset($_POST['pesan'])) {
        require 'lib/session_login.php';
        $post_kategori = $conn->real_escape_string(trim(filter($_POST['kategori'])));
        $post_layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
        $post_jumlah = $conn->real_escape_string(trim(filter($_POST['jumlah'])));
        $post_target = $conn->real_escape_string(trim(filter($_POST['target'])));
        $post_comments = $_POST['comments'];

        $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed  WHERE service_id = '$post_layanan' AND status = 'Aktif'");
        $data_layanan = mysqli_fetch_assoc($cek_layanan);

        if ($data_layanan['refill'] == "1") {
            $refill_button = "YA";
        } else {
            $refill_button = "TIDAK";
        }

        $cek_pesanan = $conn->query("SELECT * FROM pembelian_sosmed WHERE target = '$post_target' AND status = 'Pending'");
        $data_pesanan = mysqli_fetch_assoc($cek_pesanan);


        $cek_harga = $data_layanan['harga'] / 1000;
        $cek_profit = $data_layanan['profit'] / 1000;
        $hitung = count(explode(PHP_EOL, $post_comments));
        $replace = str_replace("\r\n", '\r\n', $post_comments);
        if (!empty($post_comments)) {
            $post_jumlah = $hitung;
        } else {
            $post_jumlah = $post_jumlah;
        }
        // $price = $rate*$post_quantity;
        if (!empty($post_comments)) {
            $harga_asli = $cek_harga * $hitung;
            $DS = $data_user['diskon_user'];
            $SET = (($harga_asli *$DS)/100);
            $harga = $harga_asli - $SET;
            
            $profit = $cek_profit * $hitung;
        } else {
            $harga_asli = $cek_harga * $post_jumlah;
            $DS = $data_user['diskon_user'];
            $SET = (($harga_asli *$DS)/100);
            $harga = $harga_asli - $SET;
            
            $profit = $cek_profit * $post_jumlah;
        }
        $order_id = acak_nomor(3) . acak_nomor(4);
        $provider = $data_layanan['provider'];

        $cek_provider = $conn->query("SELECT * FROM provider WHERE code = 'ZAYNFLAZZ'");
        $data_provider = mysqli_fetch_assoc($cek_provider);

        $cek_wa = $conn->query("SELECT * FROM bot_whatsapp WHERE status = 'Aktif'");
        $data_wa_bot = $cek_wa->fetch_assoc();

        //Get Start Count
        if ($data_layanan['kategori'] == "Instagram Likes" and "Instagram Likes Indonesia" and "Instagram Likes [Targeted Negara]" and "Instagram Likes/Followers Per Minute") {
            $start_count = likes_count($post_target);
        } else if ($data_layanan['kategori'] == "Instagram Followers No Refill/Not Guaranteed" and "Instagram Followers Indonesia" and "Instagram Followers [Negara]" and "Instagram Followers [Refill] [Guaranteed] [NonDrop]") {
            $start_count = followers_count($post_target);
        } else if ($data_layanan['kategori'] == "Instagram Views") {
            $start_count = views_count($post_target);
        } else {
            $start_count = 0;
        }

        if (!$post_target || !$post_layanan || !$post_kategori) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Harap Mengisi Semua Form Input');
        } else if (mysqli_num_rows($cek_layanan) == 0) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Layanan Tidak Tersedia.');
        } else if (mysqli_num_rows($cek_provider) == 0) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Server Sedang Maintance.');
        } else if ($post_jumlah < $data_layanan['min']) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Jumlah Minimal Pemesanan Adalah ' . number_format($data_layanan['min'], 0, ',', '.') . '.');
        } else if ($post_jumlah > $data_layanan['max']) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Jumlah Maksimal Pemesanan Adalah ' . number_format($data_layanan['max'], 0, ',', '.') . '.');
        } else if ($data_user['saldo'] < $harga) {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Saldo Anda Tidak Mencukupi Untuk Melakukan Pemesanan Ini.');
        } else {

            if ($provider == "MANUAL") {
                $api_postdata = "";
            } else if ($provider == "ZAYNFLAZZ") {
                if ($post_comments == false) {
                    $postdata = "api_key=" . $data_provider['api_key'] . "&action=pemesanan&layanan=" . $data_layanan['provider_id'] . "&target=$post_target&jumlah=$post_jumlah";
                } else if ($post_comments == true) {
                    $postdata = "api_key=" . $data_provider['api_key'] . "&action=pemesanan&layanan=" . $data_layanan['provider_id'] . "&target=$post_target&custom_comments=$post_comments";
                }

                $endpoint = $data_provider['link'];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $chresult = curl_exec($ch);
                curl_close($ch);
                $json_result = json_decode($chresult, true);
            } else {
                die("System Error!");
            }
            if ($provider == "ZAYNFLAZZ" and $json_result['status'] == false) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => '' . $json_result['data']['pesan'] . '.');
            } else {
                if ($provider == "ZAYNFLAZZ") {
                    $provider_oid = $json_result['data']['id'];
                }

                if ($conn->query("INSERT INTO pembelian_sosmed VALUES ('','$order_id', '$provider_oid', '$sess_username', '" . $data_layanan['layanan'] . "', '$post_target', '$post_jumlah', '0', '$start_count', '$harga', '$profit', 'Pending', '$date', '$time', '$provider', 'Website', '0', '$refill_button')") == true) {
                    $conn->query("UPDATE users SET saldo = saldo-$harga, pemakaian_saldo = pemakaian_saldo+$harga WHERE username = '$sess_username'");
                    $conn->query("INSERT INTO history_saldo VALUES ('', '$sess_username', 'Pengurangan Saldo', '$harga', 'Pemesanan Sosial Media Dengan Order ID $order_id', '$date', '$time')");

                    $jumlah = number_format($post_jumlah, 0, ',', '.');
                    $harga2 = number_format($harga, 0, ',', '.');
                    $_SESSION['hasil'] = array(
                        'alert' => 'success',
                        'judul' => 'Pesanan Berhasil.<br />',
                        'pesan' => '<b>Order ID : </b> ' . $order_id . '<br />
    				 <b>Layanan : </b> ' . $data_layanan['layanan'] . '<br />
    				 <b>Target : </b> ' . $post_target . '<br />
    				 <b>Start Count : </b> ' . $start_count . '<br />
    				 <b>Jumlah Pesan : </b> ' . $jumlah . '<br />
    				 <b>Total Harga : </b> Rp ' . $harga2 . ''
                    );
                    // PESAN WA
                    $target = $data_user['nomer'];
                    $nama_user = $data_user['nama'];
                    $token_whatsapp =  $data_wa_bot['token_wa'];
                    $waktu_order = (tanggal_indo($date));
                    $webstes = $config['web']['url'];
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.fonnte.com/send',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => array(
                            'target' => $target,
                            'message' => "INVOICE ORDER SOSIAL MEDIA\n\n𝙄𝘿 : $order_id\nTanggal & Waktu : $waktu_order - $time WIB\nLayanan : " . $data_layanan['layanan'] . "\nHarga : $harga\nTarget : $post_target\nStatus : Pending\n\nby : $webstes",
                        ),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: $token_whatsapp " //change TOKEN to your actual token
                        ),
                    ));

                    $response = curl_exec($curl);
                    curl_close($curl);
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Error System (2)');
                }
            }
        }
        header("Location: " . $_SERVER['REQUEST_URI'] . "");
        exit();
    }
    require("lib/header.php");
    ?>
        <div class="content-wrapper">
          
          <?php
          //$date = date("Y-m-d");
          $cek_berita = $conn->query("SELECT * FROM berita ORDER BY id DESC");
          if(mysqli_num_rows($cek_berita) != "0"){
           ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-dark alert-dismissible" role="alert">
                        <button type="button" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <strong><i class="mdi mdi-bell-ring"></i> Informasi Terbaru!</strong>
                        <marquee style="max-height:25px" behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();">
                            <p style="font-size: 12pt">
                                <?php
                                while ($data_berita = $cek_berita->fetch_assoc()) {
                                ?>
                                <b><?php echo $data_berita['subjek']; ?> - </b> <?php echo $data_berita['konten']; ?> 
                               <?php } ?>
                            </p>
                        </marquee>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
             <?php } ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-dark">-Baca <b>Informasi</b> yang terletak dikanan (PC/Tablet) / dibawah (Smartphone) form sebelum melakukan pemesanan.</div>
                </div>
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
                <div class="col-md-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">- Pemesanan Baru</h4>
                            <form class="forms-sample" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                <div class="form-group">
                                    <label>Pilih Kategori</label>
                                    <select class="js-example-basic-single" name="kategori" id="kategori" style="width:100%">
                                        <option value="">Pilih Kategori...</option>
                                        <?php
                                        $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                        while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                        ?>
                                            <option value="<?php echo $data_kategori['id']; ?>"><?php echo $data_kategori['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Layanan</label>
                                    <select class="js-example-basic-single" name="layanan" id="layanan" style="width:100%">
                                        <option value="0">Pilih Layanan...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div id="catatan"></div>
                                </div>
                                <div class="form-group">
                                    <label for="target">Target</label>
                                    <input type="text" class="form-control" id="target" name="target">
                                </div>
                                <div id="show1">
                                    <div class="form-group">
                                        <label for="target">Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" onkeyup="get_total(this.value).value;">
                                    </div>
                                    <input type="hidden" id="rate" value="0">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Total Harga</span>
                                            </div>
                                            <input type="number" class="form-control" id="total" readonly style="background: #000;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">IDR</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="show2" style="display: none;">
                                    <div class="form-group">
                                        <label for="comments">Comments</label>
                                        <textarea class="form-control" name="comments" id="comments" placeholder="Pisahkan Tiap Baris komentar dengan enter" rows="4"></textarea>
                                    </div>
                                    <input type="hidden" id="rate" value="0">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Total Harga</span>
                                            </div>
                                            <input type="number" class="form-control" id="totalxx" readonly style="background: #000;">
                                            <div class="input-group-append">
                                                <span class="input-group-text">IDR</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="reset" class="btn btn-dark mr-2">Cancel</button>
                                <button type="submit" name="pesan" class="btn btn-info float-right">Order Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">- RULES ORDER</h4>
                            <ul>
                                <li>Pastikan Anda memenginput link yang benar sesuai format yang ada di keterangan, karena kami tidak bisa membatalkan pesanan.</li>
                                <li>Jangan menggunakan lebih dari satu layanan sekaligus untuk username/link yang sama. Harap tunggu status completed pada orderan sebelumnya baru melakukan orderan kepada username/ link yang sama. Hal ini tidak akan membantu mempercepat orderan Anda karena kedua orderan bisa jadi berstatus completed tetapi hanya tercapai target dari salah satu orderan dan tidak ada pengembalian dana.</li>
                                <li>Setelah order dimasukan, jika username/link yang diinput tidak ditemukan (diganti, menjadi pribadi), orderan akan otomatis menjadi completed dan tidak ada pengembalian dana.</li>
                                <li>Kesalahan jumlah order dll oleh member, bukan tanggung jawab akmi, karena panel ini serba automatis, jadi hati-hati dan perhatikan sebelum order dan tidak ada pengembalian dana!</li>
                                <li>Jika Orderan status partial & canceled, saldo otomatis di refund dan bisa order ulang!</li>
                                <li>Jumlah MAX menunjukkan kapasitas layanan tersebut untuk satu target (akun/link) bukan menunjukkan kapasitas maks sekali order. Apabila Anda telah menggunakan semua kapasitas MAX layanan, Anda tidak bisa menggunakan layanan itu lagi dan harus menggunakan layanan yang lain. Oleh karenannya kami menyediakan banyak layanan dengan kapasitas maks yang lebih besar.</li>
                                <li>Informasi yang terdapat pada kolom keterangan (speed, drop rate, bersifat estimasi untuk membedakan layanan yang satu dan lainnya.Informasi bisa jadi tidak akurat tergantung dari performa server dan jumlah orderan yang masuk pada server tersebut. Anda dapat report setelah 24 jam orderan disubmit.</li>
                                <li>Dengan melakukan orderan Anda dianggap sudah memahami dan setuju <a href="/halaman/syarat-ketentuan">Syarat dan Ketentuan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    <?php
    require 'lib/footer.php';
}
    ?>