<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo strtoupper($data['short_title']); ?> - <?php echo strtoupper($data['title']); ?></h4>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">Solusi Terjangkau dan Efektif</h6>
                            <p class="text-muted mb-0"><?php echo strtoupper($data['short_title']); ?> menawarkan layanan SMM panel terbaik dan termurah di pasaran, yang dapat dinikmati oleh bisnis dan individu dari semua kalangan. Dengan solusi layanan kami yang terjangkau, Anda dapat mencapai sasaran pemasaran digital tanpa menguras kantong.</p>
                        </div>
                    </div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                        <div class="text-md-center text-xl-left">
                            <h6 class="mb-1">Layanan Lengkap</h6>
                            <p class="text-muted mb-0"><?php echo strtoupper($data['short_title']); ?> memberikan solusi untuk Instagram, Youtube, Facebook, dan TikTok, memberikan Anda solusi lengkap dan komprehensif untuk semua kebutuhan social media marketing Anda. Dengan platform kami, Anda dapat menjangkau lebih banyak orang, meningkatkan interaksi, dan meningkatkan kepercayaan calon konsumen serta kredibilitas brand.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <h4 class="card-title mb-1">Hubungi Kami Melalui Kontak Di Bawah Ini.</h4>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="preview-list">
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-whatsapp"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">WhatsApp</h6>
                                            <p class="text-muted mb-0"><?php echo $data['wa_number']; ?></p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted"><a href="https://api.whatsapp.com/send?phone=<?php echo $data['wa_number']; ?>" target="_blank" class="btn btn-sm btn-info">Hubungi Saya</a></p>
                                            <p class="text-muted mb-0">Klik untuk memulai pesan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-danger">
                                            <i class="mdi mdi-instagram"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">Instagram</h6>
                                            <p class="text-muted mb-0"><?php echo $data['ig_akun']; ?></p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted"><a href="https://www.instagram.com/<?php echo $data['ig_akun']; ?>" target="_blank" class="btn btn-sm btn-info">Hubungi Saya</a></p>
                                            <p class="text-muted mb-0">Klik untuk memulai pesan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-facebook"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">Facebook</h6>
                                            <p class="text-muted mb-0"><?php echo $data['facebook_akun']; ?></p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted"><a href="https://www.facebook.com/<?php echo $data['facebook_akun']; ?>" target="_blank" class="btn btn-sm btn-info">Hubungi Saya</a></p>
                                            <p class="text-muted mb-0">Klik untuk memulai pesan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item border-bottom">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-primary">
                                            <i class="mdi mdi-twitter"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">Twitter</h6>
                                            <p class="text-muted mb-0"><?php echo $data['twitter']; ?></p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted"><a href="https://www.twitter.com/<?php echo $data['twitter']; ?>" target="_blank" class="btn btn-sm btn-info">Hubungi Saya</a></p>
                                            <p class="text-muted mb-0">Klik untuk memulai pesan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-danger">
                                            <i class="mdi mdi-email"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content d-sm-flex flex-grow">
                                        <div class="flex-grow">
                                            <h6 class="preview-subject">Email</h6>
                                            <p class="text-muted mb-0"><?php echo $data['email_akun']; ?></p>
                                        </div>
                                        <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                            <p class="text-muted"><a href="https://mail.google.com/mail/u/0/?view=cm&tf=1&fs=1&to=<?php echo $data['email_akun']; ?>" target="_blank" class="btn btn-sm btn-info">Hubungi Saya</a></p>
                                            <p class="text-muted mb-0">Klik untuk memulai pesan</p>
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
<?php
require '../lib/footer.php';
?>