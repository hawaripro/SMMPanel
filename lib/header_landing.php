<?php
require 'session_login.php';
require 'database.php';
require 'csrf_token.php';
?>
<html id="theme_23" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo strtoupper($data['short_title']); ?> : <?php echo strtoupper($data['title']); ?></title>
    <meta name="description" content="<?php echo $data['deskripsi_web']; ?>">
    <meta name="keywords" content="<?php echo $data['keyword']; ?>">

    <!--ICON LOGO-->
   <link rel="shortcut icon" type="image/ico" href="/assets/images/favicon/<?php echo $data['favicon']; ?>" />
    <!--END ICON LOGO-->

    <link rel="stylesheet" type="text/css" href="/landing/assets/76qh3t8daycj0hy.css">
    <link rel="stylesheet" type="text/css" href="/landing/assets/hzfxl58g8052fu0.css">
    <link rel="stylesheet" type="text/css" href="/landing/assets/whatsapp.css">
</head>

<body class="body  body-public">
    <div class="wrapper  wrapper-navbar ">
        <div id="block_112">
            <div class="block-wrapper">
                <div class="component_navbar ">
                    <div class="component-navbar__wrapper">
                        <div class="component-navbar component-navbar__navbar-public component-navbar__navbar-public-padding editor__component-wrapper">
                            <div>
                                <nav class="navbar navbar-expand-lg navbar-light navbar-rows">
                                    <div class="navbar-public__header">
                                        <div class="sidebar-block__top-brand">
                                            <div class="component-navbar-logo">
                                                <a href="/">
                                                    <img src="/assets/images/header-logo/<?php echo $data['header_logo']; ?>" class="sidebar-block__top-logo" alt="Smm Panel Indonesia" title="smm panel indonesia">
                                                </a>
                                            </div>
                                        </div>
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-112" aria-controls="navbar-collapse-112" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-burger">
                                                <span class="navbar-burger-line"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="collapse navbar-collapse" id="navbar-collapse-112">
                                        <div class="d-flex flex-wrap component-navbar-collapse">
                                            <ul class="navbar-nav">
                                                <li class="nav-item component-navbar-nav-item component-navbar-public-nav-item nav-item-height">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public component-navbar-nav-link-active__navbar-public" href="/auth/login"><i class="navbar-icon fas fa-sign-in-alt"></i> Masuk</a>
                                                </li>
                                                <li class="nav-item component-navbar-nav-item component-navbar-public-nav-item nav-item-height">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public " href="/halaman/harga-layanan"><i class="navbar-icon fas fa-ballot"></i> Layanan</a>
                                                </li>
                                                <li class="nav-item component-navbar-nav-item component-navbar-public-nav-item nav-item-height">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public " href="/halaman/api-dokumentasi"><i class="navbar-icon fab fa-autoprefixer"></i> API</a>
                                                </li>
                                                <li class="nav-item component-navbar-nav-item component-navbar-public-nav-item nav-item-height">
                                                    <a class="component-navbar-nav-link component-navbar-nav-link__navbar-public " href="/auth/register"><i class="navbar-icon fad fa-user-alt"></i> Daftar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;
        ?>