<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
if (isset($_POST['kirim'])) {
    require '../lib/session_login.php';
    $post_subjek = $conn->real_escape_string(trim(filter($_POST['subjek'])));
    $post_pesan = $conn->real_escape_string(trim(filter($_POST['pesan'])));

    $cek_tiket_pending = $conn->query("SELECT * FROM tiket WHERE user = '$sess_username' AND status = 'Pending'");

    if (!$post_subjek || !$post_pesan) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Harap Mengisi Semua Input');
    } else if (mysqli_num_rows($cek_tiket_pending) == 5) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Masih Ada 5 Tiket Pending, Silahkan Tunggu Balasan Tim Support. <br>Anda hanya diperbolehkan mebuat 5 tiket berstatus pending silahkan menunggu balasan team support sebelum membuat tiket baru');
    } else if (strlen($post_pesan) > 1000) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Maksimal Pengisian Pada Form Pesan Adalah 1000 Karakter');
    } else {
        $insert_tiket = $conn->query("INSERT INTO tiket VALUES ('', '$sess_username', '$post_subjek', '$post_pesan', '$date', '$time', '$date $time', 'Pending','1','0')");
        if ($insert_tiket == TRUE) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Sukses', 'pesan' => 'Tiket Berhasil Dibuat, Harap Menunggu Respon Dari team-support kami.');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Error System(Insert To Database).');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
}
require("../lib/header.php");
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
        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">- OPEN TIKET</h4>
                    <form class="forms-sample" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                        <div class="form-group">
                            <label>Judul Tiket</label>
                            <select class="js-example-basic-single" name="subjek" id="subjek" style="width:100%">
                                <option value="">Pilih Judul Tiket ...</option>
                                <option value="ORDER">ORDER</option>
                                <option value="DEPOSIT">DEPOSIT</option>
                                <option value="LAYANAN">LAYANAN</option>
                                <option value="LAINNYA">LAINNYA</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan Tiket</label>
                            <textarea class="form-control" name="pesan" id="pesan" placeholder="Pesan mengenai masalah order dan lainnya" rows="4"></textarea>
                        </div>
                        <button type="submit" name="kirim" class="btn btn-info float-right">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">- INFORMASI TIKET/PENGISIAN JUDUL</h4>
                    <ul>
                        <li><b>ORDER :</b> Masalah mengenai dengan pemesanan.</li>
                        <li><b>DEPOSIT :</b> Masalah mengenai dengan deposit saldo.</li>
                        <li><b>LAYANAN :</b> Masalah mengenai dengan layanan/services.</li>
                        <li><b>LAINNYA :</b> Masalah lainnya yang ingin di bantu atau di tanyakan.</li>
                        <li>Sertakan ID pemesanan/deposit saat melalukan komplain pesanan/deposit yang bermasalah</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Status</badge>
                                <select class="form-control" name="status">
                                    <option value="">Semua</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Responded">Responded</option>
                                    <option value="Waiting">Waiting</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Cari ID Tiket/Judul</badge>
                                <input type="text" class="form-control" name="cari" placeholder="Cari ID/Judul" value="">
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
                                    <th> ID Tiket</th>
                                    <th> Judul </th>
                                    <th> Pesan </th>
                                    <th> Updated Time </th>
                                    <th> Status </th>
                                    <th> Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));

                                    $cek_tiket = "SELECT * FROM tiket WHERE subjek LIKE '%$cari_oid%' OR id LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' AND user = '$sess_username' ORDER BY id DESC"; // edit
                                } else {
                                    $cek_tiket = "SELECT * FROM tiket WHERE user = '$sess_username' ORDER BY id DESC"; // edit
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
                                $new_query = $cek_tiket . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_tiket = $new_query->fetch_assoc()) {
                                    if ($data_tiket['status'] == "Pending") {
                                        $label = "warning";
                                        $btn = "";
                                    } else if ($data_tiket['status'] == "Closed") {
                                        $label = "danger";
                                        $btn = "disabled";
                                    } else if ($data_tiket['status'] == "Waiting") {
                                        $label = "primary";
                                        $btn = "";
                                    } else if ($data_tiket['status'] == "Responded") {
                                        $label = "success";
                                        $btn = "";
                                    }
                                ?>
                                    <tr>
                                        <td>[ <?php echo $data_tiket['id']; ?> ]</td>
                                        <td><b><?php echo $data_tiket['subjek']; ?></td>
                                        <td><?php echo $data_tiket['pesan']; ?></td>
                                        <td><?php echo time_elapsed_string($data_tiket['update_terakhir']); ?></td>
                                        <td><span class="btn btn-xs btn-<?php echo $label; ?>"><?php echo $data_tiket['status']; ?></span></td>
                                        <td><a href="<?php echo $config['web']['url']; ?>tiket/open-tiket?id=<?php echo $data_tiket['id']; ?>" class="btn btn-sm btn-info <?php echo $btn; ?>"><i class="mdi mdi-near-me"></i> Balas</a></td>
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
                            $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                            $cari_status = $conn->real_escape_string(filter($_GET['status']));
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $self = $_SERVER['PHP_SELF'];
                        }
                        $cek_tiket = $conn->query($cek_tiket);
                        $total_records = mysqli_num_rows($cek_tiket);
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
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_oid . "'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_oid . "'><</a></li>";
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
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_oid . "'>" . $i . "</a></li>";
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
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_oid . "'>></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_oid . "'>>></a></li>";
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
<?php
require '../lib/footer.php';
?>