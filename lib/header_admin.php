<?php require 'database.php'; ?>
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
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/">
                        <span class="menu-icon">
                            <i class="mdi mdi-dialpad"></i>
                        </span>
                        <span class="menu-title">Dashboard Admin</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/berita">
                        <span class="menu-icon">
                            <i class="mdi mdi-bell-ring"></i>
                        </span>
                        <span class="menu-title">Berita Informasi</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/users">
                        <span class="menu-icon">
                            <i class="mdi mdi-account-multiple"></i>
                        </span>
                        <span class="menu-title">Kelola Users</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/pemesanan">
                        <span class="menu-icon">
                            <i class="mdi mdi-cart"></i>
                        </span>
                        <span class="menu-title">Kelola Pemesanan</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/refill">
                        <span class="menu-icon">
                            <i class="mdi mdi-recycle"></i>
                        </span>
                        <span class="menu-title">Kelola Data Refill</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#deposit" aria-expanded="false" aria-controls="deposit">
                        <span class="menu-icon">
                            <i class="mdi mdi-credit-card-multiple"></i>
                        </span>
                        <span class="menu-title">Metode Pembayaran</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="deposit">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="/admin/metode-manual">Metode Manual</a></li>
                            <li class="nav-item"> <a class="nav-link" href="/admin/metode-automatis">Metode Automatis</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/datadepo">
                        <span class="menu-icon">
                            <i class="mdi mdi-currency-usd"></i>
                        </span>
                        <span class="menu-title">Deposit Users</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/voucher-deposit">
                        <span class="menu-icon">
                            <i class="mdi mdi-receipt"></i>
                        </span>
                        <span class="menu-title">Voucher Deposit</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/tiket">
                        <span class="menu-icon">
                            <i class="mdi mdi-message-processing"></i>
                        </span>
                        <span class="menu-title">Kelola Tiket</span>
                        <?php if (mysqli_num_rows($AllTiketUsers) !== 0) { ?><span class="badge badge-info badge-pill notif-tiket"><?php echo mysqli_num_rows($AllTiketUsers); ?></span><?php } ?></span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#layanan" aria-expanded="false" aria-controls="layanan">
                        <span class="menu-icon">
                            <i class="mdi mdi-calendar-text"></i>
                        </span>
                        <span class="menu-title">Kelola Produk</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="layanan">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="/admin/kelola-kategori">Kelola Kategori</a></li>
                            <li class="nav-item"> <a class="nav-link" href="/admin/kelola-layanan">Kelola Layanan</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-toggle="collapse" href="#lainnya" aria-expanded="false" aria-controls="lainnya">
                        <span class="menu-icon">
                            <i class="mdi mdi-blur-linear"></i>
                        </span>
                        <span class="menu-title">Halaman Lainnya</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="lainnya">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="/admin/kelola-mutasi">Kelola Mutasi</a></li>
                            <li class="nav-item"> <a class="nav-link" href="/admin/aktifitas">Kelola Aktifitas</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/admin/configurasi">
                        <span class="menu-icon">
                            <i class="mdi mdi-receipt"></i>
                        </span>
                        <span class="menu-title"><b>CONFIG WEBSITE</b></span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="/">
                        <span class="menu-icon">
                            <i class="mdi mdi-backup-restore"></i>
                        </span>
                        <span class="menu-title"><b>HALAMAN MEMBER</b></span>
                    </a>
                </li>
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
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="/assets/images/admin-user.png" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $data_user['username']; ?></p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Profile Admin</h6>
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