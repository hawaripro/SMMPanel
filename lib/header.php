<?php
require 'session_login.php';
require 'database.php';
require 'csrf_token.php';
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
    <!-- endinject -->
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="stylesheet" type="text/css" href="/landing/assets/whatsapp.css">
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="/"><img src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="/"><img src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" alt="logo" /></a>
            </div>
            <ul class="nav">
                <?php
                if (isset($_SESSION['user'])) {
                ?>
                    <li class="nav-item profile">
                        <div class="profile-desc">
                            <div class="profile-pic">
                                <div class="count-indicator">
                                    <img class="img-xs rounded-circle " src="/assets/images/users.png" alt="">
                                    <span class="count bg-success"></span>
                                </div>
                                <div class="profile-name">
                                    <h5 class="mb-0 font-weight-normal"><?php echo $data_user['username']; ?></h5>
                                    <span>username</span>
                                </div>
                            </div>
                            <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                            <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                                <a href="/user/setting" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-settings text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1 text-small">Settings</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="/user/mutasi" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-file-document-box  text-info"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1 text-small">Cek Mutasi</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="/logout" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject ellipsis mb-1 text-small">Log Out</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item nav-category">
                        <span class="nav-link"><b>Saldo: Rp <?php echo number_format($data_user['saldo'], 0, ',', '.'); ?></b></span>
                    </li>
                <?php } ?>
                <?php
                if (isset($_SESSION['user'])) {
                ?>
                    <?php
                    if ($data_user['level'] == "Developers") {
                    ?>
                        <li class="nav-item menu-items">
                            <a class="nav-link" href="/admin/">
                                <span class="menu-icon">
                                    <i class="mdi mdi-airplay"></i>
                                </span>
                                <span class="menu-title"><b>KELOLA ADMIN</b></span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    if ($data_user['level'] != "Member") {
                    ?>
                        <!--<HALAMAN STAF LEVEL DI ATAS UMEMBER-->
                    <?php } ?>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/">
                            <span class="menu-icon">
                                <i class="mdi mdi-cart"></i>
                            </span>
                            <span class="menu-title">Pesanan Baru</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/riwayat-order">
                            <span class="menu-icon">
                                <i class="mdi mdi-file-document-box"></i>
                            </span>
                            <span class="menu-title">Riwayat Pesanan</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/riwayat-refill">
                            <span class="menu-icon">
                                <i class="mdi mdi-mdi mdi-flattr"></i>
                            </span>
                            <span class="menu-title">Riwayat Refill</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" data-toggle="collapse" href="#deposit" aria-expanded="false" aria-controls="deposit">
                            <span class="menu-icon">
                                <i class="mdi mdi-square-inc-cash"></i>
                            </span>
                            <span class="menu-title">Deposit</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="deposit">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/deposit">Deposit Baru</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/deposit/riwayat-deposit">Riwayat Deposit</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/tiket/">
                            <span class="menu-icon">
                                <i class="mdi mdi-message-processing"></i>
                            </span>
                            <span class="menu-title">Tiket Bantuan</span>
                            <?php if (mysqli_num_rows($CallDBTiket) !== 0) { ?><span class="badge badge-info badge-pill notif-tiket"><?php echo mysqli_num_rows($CallDBTiket); ?></span><?php } ?>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/harga-layanan">
                            <span class="menu-icon">
                                <i class="mdi mdi-format-list-bulleted"></i>
                            </span>
                            <span class="menu-title">Daftar Layanan</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/api-dokumentasi">
                            <span class="menu-icon">
                                <i class="mdi mdi-directions-fork"></i>
                            </span>
                            <span class="menu-title">API Dokumentasi</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" data-toggle="collapse" href="#lainnya" aria-expanded="false" aria-controls="lainnya">
                            <span class="menu-icon">
                                <i class="mdi mdi-blur-linear"></i>
                            </span>
                            <span class="menu-title">Lainnya</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="lainnya">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/halaman/syarat-ketentuan">Syarat & Ketentuan</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/halaman/kontak-kami">Kontak Kami</a></li>
                            </ul>
                        </div>
                    </li>
                <?php
                } else {
                ?>
                <li class="nav-item menu-items">
                        <a class="nav-link" href="/">
                            <span class="menu-icon">
                                <i class="mdi mdi-home"></i>
                            </span>
                            <span class="menu-title">HOME</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/auth/login">
                            <span class="menu-icon">
                                <i class="mdi mdi-account-circle"></i>
                            </span>
                            <span class="menu-title">Masuk</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/auth/register">
                            <span class="menu-icon">
                                <i class="mdi mdi-account-plus"></i>
                            </span>
                            <span class="menu-title">Daftar</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/harga-layanan">
                            <span class="menu-icon">
                                <i class="mdi mdi-format-list-bulleted"></i>
                            </span>
                            <span class="menu-title">Daftar Layanan</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" href="/halaman/api-dokumentasi">
                            <span class="menu-icon">
                                <i class="mdi mdi-directions-fork"></i>
                            </span>
                            <span class="menu-title">API Dokumentasi</span>
                        </a>
                    </li>
                    <li class="nav-item menu-items">
                        <a class="nav-link" data-toggle="collapse" href="#lainnya" aria-expanded="false" aria-controls="lainnya">
                            <span class="menu-icon">
                                <i class="mdi mdi-blur-linear"></i>
                            </span>
                            <span class="menu-title">Lainnya</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="lainnya">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/halaman/syarat-ketentuan">Syarat & Ketentuan</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/halaman/kontak-kami">Kontak Kami</a></li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a href="/"><img src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" alt="logo" width="80px" style="margin-left: 50px;"></a>
                  </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100">
                    </ul>
                    <?php
                    if (isset($_SESSION['user'])) {
                    ?>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="/assets/images/users.png" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $data_user['username']; ?></p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile</h6>
                                <div class="dropdown-divider"></div>
                                <a href="/user/setting" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-settings text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Settings</p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="/logout" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Log out</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <?php } ?>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">


                <?php
                $time = microtime();
                $time = explode(' ', $time);
                $time = $time[1] + $time[0];
                $start = $time;
                ?>