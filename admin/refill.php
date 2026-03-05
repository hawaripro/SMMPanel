<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['update'])) {
    $get_oid = $conn->real_escape_string($_GET['refill_id']);
    $status = $conn->real_escape_string($_POST['status']);

    $cek_orders = $conn->query("SELECT * FROM refill_order WHERE id = '$get_oid'");
    $data_orders = $cek_orders->fetch_array(MYSQLI_ASSOC);

    if ($cek_orders->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Data Refill Tidak Ditemukan');
    } else {
        if ($conn->query("UPDATE refill_order SET status = '$status' WHERE id = '$get_oid'") == true) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Refill Berhasil Di Update 
                    <br /> ID : ' . $get_oid . '
                    <br /> Status : ' . $status . '');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Gagal');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['hapus'])) {
    $get_oid = $conn->real_escape_string($_GET['refill_id']);
    $cek_orders = $conn->query("SELECT * FROM refill_order WHERE id = '$get_oid'");

    if ($cek_orders->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Data Refill Tidak Ditemukan');
    } else {
        if ($conn->query("DELETE FROM refill_order WHERE id = '$get_oid'") == TRUE) {
            $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Data Refill Berhasil Di Hapus 
                    <br /> ID : ' . $get_oid . '');
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
                                    <option value="Processing">Processing</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Success">Success</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Error">Error</option>
                                    <option value="Canceled">Canceled</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Cari ID Refill</badge>
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
                                    <th> Refill ID </th>
                                    <th> Order ID </th>
                                    <th> Provider ID </th>
                                    <th> Layanan & Waktu </th>
                                    <th> Target </th>
                                    <th> Provider </th>
                                    <th> Status </th>
                                    <th> Aksi Pemesanan </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));

                                    $cek_pesanan = "SELECT * FROM refill_order WHERE id LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' ORDER BY id DESC"; // edit
                                } else {
                                    $cek_pesanan = "SELECT * FROM refill_order ORDER BY id DESC"; // edit
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
                                $new_query = $cek_pesanan . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_pesanan = $new_query->fetch_assoc()) {
                                    if ($data_pesanan['status'] == "Pending") {
                                        $badge = "warning";
                                    } else if ($data_pesanan['status'] == "Partial") {
                                        $badge = "danger";
                                    } else if ($data_pesanan['status'] == "Error") {
                                        $badge = "danger";
                                    } else if ($data_pesanan['status'] == "Ditolak") {
                                        $badge = "danger";
                                    } else if ($data_pesanan['status'] == "Canceled") {
                                        $badge = "danger";
                                    } else if ($data_pesanan['status'] == "Processing") {
                                        $badge = "info";
                                    } else if ($data_pesanan['status'] == "In Progress") {
                                        $badge = "info";
                                    } else if ($data_pesanan['status'] == "Completed") {
                                        $badge = "success";
                                    } else if ($data_pesanan['status'] == "Success") {
                                        $badge = "success";
                                    }
                                ?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?refill_id=<?php echo $data_pesanan['id']; ?>" class="form-inline" role="form" method="POST">
                                            <td><?php echo $data_pesanan['id']; ?></td>
                                            <td><?php echo $data_pesanan['oid']; ?></td>
                                            <td><?php echo $data_pesanan['provider_id']; ?></td>
                                            <td><?php echo $data_pesanan['layanan']; ?> <br><small class="text-danger"><?php echo $data_pesanan['date_time']; ?> WIB</small></td>
                                            <td style="min-width: 200px;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['target']; ?>" id="target-<?php echo $data_pesanan['id']; ?>" readonly="">
                                                    <button data-toggle="tooltip" title="Copy Target" class="btn btn-xs btn-primary" type="button" onclick="copy_to_clipboard('target-<?php echo $data_pesanan['id']; ?>')"><i class="mdi mdi-content-copy"></i></button>
                                                </div>
                                            </td>
                                            <td><?php echo $data_pesanan['provider']; ?></td>
                                            <td>
                                                <select class="form-control" style="width: 100px;" name="status">
                                                    <?php if ($data_pesanan['status'] == "Success") { ?>
                                                        <option value="<?php echo $data_pesanan['status']; ?>"><?php echo $data_pesanan['status']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $data_pesanan['status']; ?>"><?php echo $data_pesanan['status']; ?></option>
                                                        <option value="Pending">Pending</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="In Progress">In Progress</option>
                                                        <option value="Success">Success</option>
                                                        <option value="Error">Error</option>
                                                        <option value="Ditolak">Ditolak</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td align="center">
                                                <button data-toggle="tooltip" title="Update" type="submit" name="update" class="btn btn-xs btn-bordred btn-info"><i class="mdi mdi-border-color"></i> Update </button>
                                                <button data-toggle="tooltip" title="Hapus" type="submit" name="hapus" class="btn btn-xs btn-bordred btn-danger"><i class="mdi mdi-delete"></i> Hapus </button>
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
                            $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
                            $cari_status = $conn->real_escape_string(filter($_GET['status']));
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $self = $_SERVER['PHP_SELF'];
                        }
                        $cek_pesanan = $conn->query($cek_pesanan);
                        $total_records = mysqli_num_rows($cek_pesanan);
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
require '../lib/footer_admin.php';
?>