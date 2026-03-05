<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['updated'])) {
    $get_id = $conn->real_escape_string($_GET['idep']);
    $nama = $conn->real_escape_string(filter($_POST['nama']));
    $fee = $conn->real_escape_string(trim($_POST['fee']));
    $min = $conn->real_escape_string(trim($_POST['min']));
    $max = $conn->real_escape_string($_POST['max']);
    $rate = $conn->real_escape_string(filter($_POST['rate']));
    $status = $conn->real_escape_string(filter($_POST['status']));

    $cek_Mdeposit = $conn->query("SELECT * FROM metode_depo1 WHERE id = '$get_id'");
    $data_Mdeposit = $cek_Mdeposit->fetch_array(MYSQLI_ASSOC);

    if (!$nama || !$min || !$max || !$rate || !$status) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Periksa Kembali Kolom Input Dengan Benar');
    } else if ($cek_Mdeposit->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Metode Deposit Tidak Ditemukan');
    } else {
        if ($conn->query("UPDATE metode_depo1 SET nama = '$nama', fee = '$fee', minimal_deposit = '$min', maksimal_deposit = '$max', rate = '$rate', keterangan = '$status' WHERE id = '$get_id'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Data Deposit Berhasil Diubah');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
}
require("../lib/header_admin.php");
?>
<style>
    img.qr {
            width: 100%;
            height: 100%;
        }
</style>
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
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="GET">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <badge>Tampilkan</badge>
                                <select class="form-control" name="tampil">
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Status</badge>
                                <select class="form-control" name="status">
                                    <option value="">Semua</option>
                                    <option value="ON">ON / Aktif</option>
                                    <option value="OFF">OFF / Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Cari Nama Pembayaran</badge>
                                <input type="text" class="form-control" name="cari" placeholder="Cari Nama" value="">
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Sumbit Filter</badge>
                                <button type="submit" class="btn btn-dark btn-lg btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> kode Channel </th>
                                    <th> Nama Pembayaran </th>
                                    <th> fee </th>
                                    <th> Min </th>
                                    <th> Max </th>
                                    <th> Rate/Bonus <a href="button" data-toggle="modal" data-target="#exampleModalLong4">
 <i class="mdi mdi-bell-ring" title="Klik Detail Keterangan Settings Rate" style="color: #fff;"> </i></th>
                                    <th> Status </th>
                                    <th> Aksinya </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_metodedepo = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));

                                    $cek_metode = "SELECT * FROM metode_depo1 WHERE nama LIKE '%$cari_metodedepo%' AND keterangan LIKE '%$cari_status%' ORDER BY nama ASC"; // edit
                                } else {
                                    $cek_metode = "SELECT * FROM metode_depo1 ORDER BY nama ASC"; // edit
                                }
                                if (isset($_GET['cari'])) {
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    $records_per_page = $cari_urut; // edit
                                } else {
                                    $records_per_page = 10; // edit
                                }

                                $starting_position = 0;
                                if (isset($_GET["halaman"])) {
                                    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"])) - 1) * $records_per_page;
                                }
                                $new_query = $cek_metode . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_metode = $new_query->fetch_assoc()) {
                                    if ($data_metode['keterangan'] == "ON") {
                                        $badge = "info";
                                    } else if ($data_metode['keterangan'] == "OFF") {
                                        $badge = "danger";
                                    }
                                ?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?idep=<?php echo $data_metode['id']; ?>" class="form-inline" role="form" method="POST">
                                            <td><?php echo $data_metode['provider']; ?></td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 350px;" name="nama" value="<?php echo $data_metode['nama']; ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 150px;" name="fee" value="<?php echo $data_metode['fee']; ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 150px;" name="min" value="<?php echo $data_metode['minimal_deposit']; ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 150px;" name="max" value="<?php echo $data_metode['maksimal_deposit']; ?>">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 75px;" name="rate" value="<?php echo $data_metode['rate']; ?>">
                                            </td>
                                            <td>
                                                <select class="form-control" style="width: 100px;" name="status">
                                                    <option value="<?php echo $data_metode['keterangan']; ?>"><?php echo $data_metode['keterangan']; ?></option>
                                                    <option value="ON">ON</option>
                                                    <option value="OFF">OFF</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button data-toggle="tooltip" title="Update" type="submit" name="updated" class="btn btn-xs btn-bordred btn-<?php echo $badge; ?>"><i class="mdi mdi-border-color"></i> Update </button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><br>
                    <ul class="pagination pagination-sm m-0 float-right">
                        <?php
                        // start paging link
                        if (isset($_GET['cari'])) {
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $cari_urut =  10;
                        }
                        if (isset($_GET['cari'])) {
                            $cari_metodedepo = $conn->real_escape_string(filter($_GET['cari']));
                            $cari_status = $conn->real_escape_string(filter($_GET['status']));
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $self = $_SERVER['PHP_SELF'];
                        }
                        $cek_metode = $conn->query($cek_metode);
                        $total_records = mysqli_num_rows($cek_metode);
                        echo "<li class='disabled page-item'><a class='page-link' href='#'>Total : " . $total_records . "</a></li>";
                        if ($total_records > 0) {
                            $total_pages = ceil($total_records / $records_per_page);
                            $current_page = 1;
                            if (isset($_GET["halaman"])) {
                                $current_page = $conn->real_escape_string(filter($_GET["halaman"]));
                                if ($current_page < 1) {
                                    $current_page = 1;
                                }
                            }
                            if ($current_page > 1) {
                                $previous = $current_page - 1;
                                if (isset($_GET['cari'])) {
                                    $cari_metodedepo = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_metodedepo . "'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_metodedepo . "'><</a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "'><</a></li>";
                                }
                            }
                            // limit page
                            $limit_page = $current_page + 3;
                            $limit_show_link = $total_pages - $limit_page;
                            if ($limit_show_link < 0) {
                                $limit_show_link2 = $limit_show_link * 2;
                                $limit_link = $limit_show_link - $limit_show_link2;
                                $limit_link = 3 - $limit_link;
                            } else {
                                $limit_link = 3;
                            }
                            $limit_page = $current_page + $limit_link;
                            // end limit page
                            // start page
                            if ($current_page == 1) {
                                $start_page = 1;
                            } else if ($current_page > 1) {
                                if ($current_page < 4) {
                                    $min_page  = $current_page - 1;
                                } else {
                                    $min_page  = 3;
                                }
                                $start_page = $current_page - $min_page;
                            } else {
                                $start_page = $current_page;
                            }
                            // end start page
                            for ($i = $start_page; $i <= $limit_page; $i++) {
                                if (isset($_GET['cari'])) {
                                    $cari_metodedepo = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_metodedepo . "'>" . $i . "</a></li>";
                                    }
                                } else {
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "'>" . $i . "</a></li>";
                                    }
                                }
                            }
                            if ($current_page != $total_pages) {
                                $next = $current_page + 1;
                                if (isset($_GET['cari'])) {
                                    $cari_metodedepo = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_metodedepo . "'>></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_metodedepo . "'>>></a></li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "'>></i></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "'>>></a></li>";
                                }
                            }
                        }
                        // end paging link
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MODAL-->
<div class="modal fade" id="exampleModalLong4">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-bell-ring"></i> Cara Seting Rate/Bonus deposit</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>1 = bonus 0% dari jumlah deposit</li>
                    <li>1.05 = bonus 5% dari jumlah deposit</li>
                    <li>1.1 = bonus 10% dari jumlah deposit</li>
                    <li>1.2 = bonus 20% dari jumlah deposit</li>
                    <li>2 = bonus 100% dari jumlah deposit</li>
                    <li>SESUAIKAN BONUS DEPOSIT SESUAI KEINGINAN ANDA!</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
require '../lib/footer_admin.php';
?>