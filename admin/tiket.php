<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
 if (isset($_POST['tutup'])) {
            $PostID = $conn->real_escape_string($_POST['id']);
            $CheckTiket = $conn->query("SELECT * FROM tiket WHERE id = '$PostID'");
            if ($CheckTiket->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Tiket Tidak Di Temukan');
            } else {
                $tutup = $conn->query("UPDATE tiket SET status = 'Closed' WHERE id = '$PostID'");
                if ($tutup == TRUE) {
                    $_SESSION['hasil'] = array(
                        'alert' => 'success', 
                        'judul' => 'Berhasil', 
                        'pesan' => 'Tiket Berhasil Di Tutup');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
                }
            }
             header("Location: " . $_SERVER['REQUEST_URI'] . "");
             exit(); 
        } else if (isset($_POST['delete'])) {
            $PostID = $conn->real_escape_string($_POST['id']);
            $CheckTiket = $conn->query("SELECT * FROM tiket WHERE id = '$PostID'");
            if ($CheckTiket->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Tiket Tidak Di Temukan');
            } else {
                $tutup = $conn->query("DELETE FROM tiket WHERE id = '$PostID'");
                if ($tutup == TRUE) {
                    $_SESSION['hasil'] = array(
                        'alert' => 'success', 
                        'judul' => 'Berhasil', 
                        'pesan' => 'Tiket Berhasil Di Hapus');
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
                                <badge>Cari ID Tiket</badge>
                                <input type="text" class="form-control" name="cari" placeholder="Cari ID" value="">
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
                                    <th> ID </th>
                                    <th> Waktu </th>
                                    <th> Username </th>
                                    <th> Update </th>
                                    <th> Judul </th>
                                    <th> Status </th>
                                    <th> Aksi Tiket</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));

                                    $cek_tikets = "SELECT * FROM tiket WHERE id LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' ORDER BY id DESC"; // edit
                                } else {
                                    $cek_tikets = "SELECT * FROM tiket ORDER BY id DESC"; // edit
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
                                $new_query = $cek_tikets . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_tiket = $new_query->fetch_assoc()) {
                                    if ($data_tiket['status'] == "Pending") {
                                        $badge = "warning";
                                    } else if ($data_tiket['status'] == "Closed") {
                                        $badge = "danger";
                                    } else if ($data_tiket['status'] == "Waiting") {
                                        $badge = "primary";
                                    } else if ($data_tiket['status'] == "Responded") {
                                        $badge = "success";
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $data_tiket['id']; ?></td>
                                        <td><?php echo tanggal_indo($data_tiket['date']); ?>, <?php echo $data_tiket['time']; ?> WIB</td>
                                        <td><?php echo $data_tiket['user']; ?></td>
                                        <td><?php echo time_elapsed_string($data_tiket['update_terakhir']); ?></td>
                                        <td>
                                            <?php echo $data_tiket['subjek']; ?>
                                        </td>
                                        <td>
                                            <badge class="badge badge-outline-<?php echo $badge; ?>"> <?php echo $data_tiket['status'] ?></badge>
                                        </td>
                                        <td>
                                            <a href="<?php echo $config['web']['url']; ?>admin/ajax/tiket/reply.php?id=<?php echo $data_tiket['id']; ?>" class="btn btn-xs btn-bordred btn-info"><i class="mdi mdi-near-me" data-toggle="tooltip" title="Reply"></i> Balas </a>
                                            <a href="javascript:;" onclick="users('/admin/ajax/tiket/tutup.php?id=<?php echo $data_tiket['id']; ?>')" class="btn btn-xs btn-bordred btn-warning"><i class="mdi mdi-comment-remove-outline" data-toggle="tooltip" title="Tutup Tiket"></i> Tutup </a>
                                            <a href="javascript:;" onclick="users('/admin/ajax/tiket/hapus.php?id=<?php echo $data_tiket['id']; ?>')" class="btn btn-xs btn-bordred btn-danger"><i class="mdi mdi-cup-off" data-toggle="tooltip" title="Hapus tiket"></i> Hapus </a>
                                        </td>
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
                        $cek_tikets = $conn->query($cek_tikets);
                        $total_records = mysqli_num_rows($cek_tikets);
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
<!--MODAL-->
<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="mdi mdi-comment"></i> Detail Tiket</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-detail-body">
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