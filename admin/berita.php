<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['update'])) {
    $judul = $conn->real_escape_string(filter($_POST['judul']));
    $konten = $conn->real_escape_string(filter($_POST['konten']));
    if (!$judul || !$konten) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Judul / Konten Tidak Boleh Kosong.');
    } else {
        if ($conn->query("UPDATE berita SET date = '$date', time = '$time', subjek = '$judul', konten = '$konten' WHERE id = '1'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Berita Telah Berhasil Di Updated');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} 
require '../lib/header_admin.php';
?>
<div class="content-wrapper">
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
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">UBAH DENGAN BERITA BARU</h4>
                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                            <label for="judul">Judul Berita</label>
                            <input type="text" class="form-control" id="judul" name="judul">
                        </div>
                        <div class="form-group">
                            <label for="konten">Konten  Berita</label>
                            <textarea class="form-control" name="konten" id="konten"></textarea>
                        </div>
                        <button type="submit" class="pull-right btn btn-info btn-block waves-effect w-md waves-light" name="update"><i class="ti-wallet"></i> UBAH BERITA</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">BERITA TAMPIL SAAT INI<br>
                    <code>*Berita di tampilkan di dashboard pemesanan member.</code></h4>
                    <p>
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
                    </p>
                </div>    
            </div>
        </div>
    </div>
</div>
<?php
require '../lib/footer_admin.php';
?>