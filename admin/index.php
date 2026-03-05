<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
require '../lib/header_admin.php';
?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card corona-gradient-card">
                <div class="card-body py-0 px-0 px-sm-3">
                    <div class="row align-items-center">
                        <div class="col-4 col-sm-3 col-xl-2">
                            <img src="/assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                        </div>
                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                            <h3 class="mb-1 mb-sm-0">HALAMAN KELOLA ADMIN!</h3>
                        </div>
                        <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                            <img src="/assets/images/admin-kelola.png" class="gradient-corona-img img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0"><?php echo $total_pengguna; ?></h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-info ">
                                <span class="mdi mdi-account-multiple icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Users</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Rp <?php echo number_format($data_pesanan_sosmed['total'], 0, ',', '.'); ?></h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium">(<?php echo $count_pesanan_sosmed; ?>)</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success">
                                <span class="mdi mdi-cart icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Pemesanan</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Rp <?php echo number_format($data_deposit['total'], 0, ',', '.'); ?></h3>
                                <p class="text-primary ml-2 mb-0 font-weight-medium">(<?php echo $count_deposit; ?>)</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-primary">
                                <span class="mdi mdi-camera-switch icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Deposit</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">Rp <?php echo number_format($data_saldoUser['total'], 0, ',', '.'); ?></h3>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-warning ">
                                <span class="mdi mdi-cash-multiple icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Saldo Users</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">INFORMASI STATUS PEMESANAN</h4>
                    <p class="card-description">
                        Menampilkan seluruh data berlangsung dari (<?php echo $count_pesanan_sosmed; ?>) Pesanan
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> Status </th>
                                    <th> Progress </th>
                                    <th> Jumlah </th>
                                    <th> Amount </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="badge badge-warning">Pending</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $total_sosmed_pending; ?>%" aria-valuenow="<?php echo $total_sosmed_pending; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_pending; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_pending['total'], 0, ',', '.'); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="badge badge-success">Success</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $total_sosmed_succes; ?>%" aria-valuenow="<?php echo $total_sosmed_succes; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_succes; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_success['total'], 0, ',', '.'); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="badge badge-primary">Processing</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $total_sosmed_processing; ?>%" aria-valuenow="<?php echo $total_sosmed_processing; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_processing; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_processing['total'], 0, ',', '.'); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="badge badge-primary">In Progress</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $total_sosmed_progress; ?>%" aria-valuenow="<?php echo $total_sosmed_progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_progress; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_progress['total'], 0, ',', '.'); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="badge badge-danger">Error</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $total_sosmed_error; ?>%" aria-valuenow="<?php echo $total_sosmed_error; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_error; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_error['total'], 0, ',', '.'); ?> </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="badge badge-danger">Partial</label>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $total_sosmed_partial; ?>%" aria-valuenow="<?php echo $total_sosmed_partial; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td> <?php echo $total_sosmed_partial; ?> </td>
                                    <td> Rp <?php echo number_format($data_pesanan_sosmed_partial['total'], 0, ',', '.'); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">INFORMASI PENGHASILAN</h4>
                    <p class="card-description">
                        Data penghasilan bulan ini
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-contextual">
                            <thead>
                                <tr>
                                    <th> Total Pemesanan </th>
                                    <th> Penghasilan Kotor </th>
                                    <th> Penghasilan Bersih </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-info">
                                    <td> <?php echo $CountProfitSosmed; ?> </td>
                                    <td> Rp <?php echo number_format($AllSosmed['total'], 0, ',', '.'); ?> </td>
                                    <td> Rp <?php echo number_format($ProfitSosmed['total'], 0, ',', '.'); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require '../lib/footer_admin.php';
?>