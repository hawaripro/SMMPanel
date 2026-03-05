<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>
<div class="content-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="m-t-0 text-center header-title"><i class="ri-shuffle-line mr1 text-primary"></i> Dokumentasi API</h4>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="50%">METODE HTTP</th>
                                <td>POST</td>
                            </tr>
                            <tr>
                                <th>API URL</th>
                                <td style="min-width: 220px;"><?php echo $config['web']['url']; ?>api/sosial-media</td>
                            </tr>
                            <tr>
                                <th>API KEY</th>

                                <td style="min-width: 80px;">
                                 Create Your Api Key <a href="/user/setting">craete api</a>
                                </td>
                            </tr>
                            <tr>
                                <th>FORMAT RESPON</th>
                                <td>JSON</td>
                            </tr>
                            <tr>
                                <th>CONTOH <i>CLASS</i></th>
                                <td><a href="<?php echo $config['web']['url']; ?>halaman/api-php.txt" target="_new" class="btn btn-sm btn-primary">PHP</a></td>
                            </tr>
                        </table>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item menu-items">
                            <a href="#layanan" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                 LAYANAN
                            </a>
                        </li>
                        <li class="nav-item menu-items">
                            <a href="#service" data-toggle="tab" aria-expanded="false" class="nav-link">
                              PEMESANAN
                            </a>
                        </li>
                        <li class="nav-item menu-items">
                            <a href="#order" data-toggle="tab" aria-expanded="false" class="nav-link">
                              STATUS
                            </a>
                        </li>
                        <li class="nav-item menu-items">
                            <a href="#profile" data-toggle="tab" aria-expanded="false" class="nav-link">
                              PROFILE
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="layanan">
                            <b>URL Permintaan</b>
                            <div class="alert alert-info" style="margin: 10px 0; color: #000;">
                                <?php echo $config['web']['url']; ?>api/sosial-media </div>
                            <b>Parameter</b>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>API KEY Anda</td>
                                    </tr>
                                    <tr>
                                        <td>action</td>
                                        <td><span class="badge badge-primary"> layanan </span></td>
                                    </tr>
                                </table>
                            </div>
                            <b>Contoh Respon</b>
                            <div class="alert alert-warning" style="margin: 10px 0; color: #000;">
                                <b>Sukses</b>
                                <pre>{
  "data": {
          "sid": "1"
          "kategori": " Instagram Followers Indonesia"
          "layanan": "Instagram Followers Indonesia Server 17 max 5KтЪбя╕П Real ЁЯТп"
          "min": "10"
          "max": "5.000"
          "harga": "10.200"
          "catatan": "Proses fast Real indo per akun max 5k followers"
          }
}
</pre>
                                <b>Gagal</b>
                                <pre>{
    "status": false,
    "data": {
        "pesan": "Permintaan Tidak Sesuai"
    }
}
</pre>
                            </div>
                        </div>
                        <div class="tab-pane" id="service">
                            <b>URL Permintaan</b>
                            <div class="alert alert-info" style="margin: 10px 0; color: #000;">
                                <?php echo $config['web']['url']; ?>api/sosial-media </div>
                            <b>Parameter</b>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>API KEY Anda</td>
                                    </tr>
                                    <tr>
                                        <td>action</td>
                                        <td><span class="badge badge-primary"> pemesanan </span></td>
                                    </tr>
                                    <tr>
                                        <td>layanan</td>
                                        <td>SID <br /><a href="<?php echo $config['web']['url']; ?>halaman/daftar-harga">[ ID Daftar Layanan ]</a></td>
                                    </tr>
                                    <tr>
                                        <td>target</td>
                                        <td>username / link</td>
                                    </tr>
                                    <tr>
                                        <td>jumlah</td>
                                        <td>jumlah pemesanan</td>
                                    </tr>
                                </table>
                            </div>
                            <b>Contoh Respon</b>
                            <div class="alert alert-warning" style="margin: 10px 0; color: #000;">
                                <b>Sukses</b>
                                <pre>{
  "data": {
          "id": "1119",
          "start_count": "200"
          }
}
</pre>
                                <b>Gagal</b>
                                <pre>{
    "status": false,
    "data": {
        "pesan": "Permintaan Tidak Sesuai"
    }
}
</pre>
                            </div>
                        </div>
                        <div class="tab-pane" id="order">
                            <b>URL Permintaan</b>
                            <div class="alert alert-info" style="margin: 10px 0; color: #000;">
                                <?php echo $config['web']['url']; ?>api/sosial-media </div>
                            <b>Parameter</b>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>API KEY Anda</td>
                                    </tr>
                                    <tr>
                                        <td>action</td>
                                        <td><span class="badge badge-primary"> status </span></td>
                                    </tr>
                                    <tr>
                                        <td>id</td>
                                        <td>id pemesanan</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- batas -->
                            <b>Contoh Respon</b>
                            <div class="alert alert-warning" style="margin: 10px 0; color: #000;">
                                <b>Sukses</b>
                                <pre>{
  "data": {
          "id":"23",
          "start_count":"123",
          "status":"Success",
          "remains":"0"
          }
}
</pre>
                                <b>Gagal</b>
                                <pre>{
    "status": false,
    "data": {
        "pesan": "Permintaan Tidak Sesuai"
    }
}
</pre>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="profile">
                            <b>URL Permintaan</b>
                            <div class="alert alert-info" style="margin: 10px 0; color: #000;">
                                <?php echo $config['web']['url']; ?>api/profile </div>
                            <b>Parameter</b>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    <tr>
                                        <td>api_key</td>
                                        <td>API KEY Anda</td>
                                    </tr>
                                    <tr>
                                        <td>action</td>
                                        <td><span class="badge badge-primary"> profile </span></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- batas -->
                            <b>Contoh Respon</b>
                            <div class="alert alert-warning" style="margin: 10px 0; color: #000;">
                                <b>Sukses</b>
                                <pre>{
  "data": {
          "nama": "namaakun",
          "username": "username",
          "email": "email@gmail.com",
          "sisa_saldo": "20.200",
          "total_pemakaian": "19.500"
          }
}
</pre>
                                <b>Gagal</b>
                                <pre>{
    "status": false,
    "data": {
        "pesan": "Permintaan Tidak Sesuai"
    }
}
</pre>
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