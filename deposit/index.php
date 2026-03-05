<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';
?>
<div class="content-wrapper">
    <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>DEPOSIT MANUAL</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h5 class="mb-0">BANK/E-Wallet/QRIS</h5>
                        </div><br>
                        <a href="/deposit/manual" class="text-muted font-weight-normal">
                        <button type="button" class="btn btn-info btn-fw">Pilih Pembayaran</button>
                        </a>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-credit-card-multiple text-success ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>DEPOSIT AUTOMATIS</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                           <h5 class="mb-0"> Virtual-Account/E-Wallet/Convenience Store</h5>
                        </div><br>
                        <a href="/deposit/automatis" class="text-muted font-weight-normal">
                        <button type="button" class="btn btn-info btn-fw">Pilih Pembayaran</button>
                        </a>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-credit-card-multiple text-success ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>DEPOSIT VOUCHER</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h5 class="mb-0"> Redeem Voucher</h5>
                        </div><br>
                        <a href="/deposit/voucher" class="text-muted font-weight-normal">
                        <button type="button" class="btn btn-info btn-fw">Pilih Pembayaran</button>
                        </a>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-credit-card-multiple text-success ml-auto"></i>
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