<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['tambah'])) {
    $username = $conn->real_escape_string(filter($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $level = $conn->real_escape_string($_POST['level']);
    $saldo = $conn->real_escape_string(filter($_POST['saldo']));

    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

    $cek_username = $conn->query("SELECT * FROM users WHERE username = '$username'");
    $cek_email = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $api_key =  acak(32);
    $terdaftar = "$date $time";


    if (!$username || !$email || !$password || !$level) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Harap Mengisi Semua Input Pada Form');
    } else if ($cek_username->num_rows > 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username <strong>' . $username . ' </strong> Sudah Terdaftar');
    } else if ($cek_email->num_rows > 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Email <strong> ' . $email . ' </strong> Sudah Terdaftar');
    } else if (strlen($username) < 6) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username Minimal 6 Karakter');
    } else if (strlen($password) < 6) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Password Minimal 6 Karakter');
    } else {
        if ($conn->query("INSERT INTO users VALUES ('', '$username', '$email', '', '0', '$username', '$hash_pass', '$saldo', '', '$level', 'Aktif', '$api_key', '0', '$date', '$time', '0','')") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => '
                        Perngguna Baru Telah Berhasil Ditambahkan <br />
                        Email : ' . $email . ' <br />
                        Username : ' . $username . ' <br />
                        Password : ' . $password . ' <br />
                        Level : ' . $level . ' <br />
                        Saldo : ' . $saldo . ' <br />
                        '
            );
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['edit'])) {
    $get_id = $conn->real_escape_string($_POST['id']);
    $email = filter($_POST['email']);
    $password = $conn->real_escape_string(trim($_POST['password']));
    $level = $conn->real_escape_string($_POST['level']);
    $saldo = filter($_POST['saldo']);
    $diskon = filter($_POST['diskon']);
    $status = $conn->real_escape_string($_POST['status']);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    if (!$level || !$email) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Input Tidak Boleh Kosong.');
    } else if (!empty($password) and strlen($password) < 6) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Password minimal 6 karakter.');
    } else {
        if (empty($password) == true) {
            if ($conn->query("UPDATE users SET email = '$email', level = '$level', status = '$status', saldo = '$saldo', diskon_user = '$diskon' WHERE id = '$get_id'") == true) {
                $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil!', 'pesan' => 'Data Pengguna Berhasil Diubah.');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Gagal (1).');
            }
        } else if ($password == true) {
            if ($conn->query("UPDATE users SET email = '$email', password = '$password_hash', level = '$level', status = '$status', saldo = '$saldo', diskon_user = '$diskon' WHERE id = '$get_id'") == true) {
                $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil!', 'pesan' => 'Data Pengguna Berhasil Diubah. ');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Gagal (1).');
            }
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Gagal (1).');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['delete'])) {
    $post_id = $conn->real_escape_string($_POST['id']);
    $cek_users = $conn->query("SELECT * FROM users WHERE id = '$post_id'");
    if ($cek_users->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username Tidak Di Temukan');
    } else {
        if ($conn->query("DELETE FROM users WHERE id = '$post_id'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Pengguna Berhasil Di Hapus'
            );
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['change_api'])) {
    $post_id = $conn->real_escape_string($_GET['id']);
    $cek_users = $conn->query("SELECT * FROM users WHERE id = '$post_id'");
    $api_key =  acak(32);
    if ($cek_users->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username Tidak Di Temukan');
    } else {
        if ($conn->query("UPDATE users SET api_key = '$api_key' WHERE id = '$post_id'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'API Key Sukses Di Update'
            );
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
}
require("../lib/header_admin.php");
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
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Users Aktif</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $aktif; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-account-multiple text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Users Non Aktif</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $nonaktif; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-account-off text-danger ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Saldo Users</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0">Rp <?php echo number_format($data_saldoUser['total'], 0, ',', '.'); ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-cash-multiple text-warning ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--MODAL-->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="mdi mdi-account-plus"></i> Tambah Pengguna</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilih Level</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="level">
                                    <option value="">Pilih Level..</option>
                                    <option value="Member">Member</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Developers">Developers</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" name="username" class="form-control" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="text" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Saldo</label>
                            <div class="col-sm-9">
                                <input type="number" name="saldo" class="form-control" placeholder="Saldo">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info btn-bordred waves-effect w-md waves-light" name="tambah">Tambah Users</button>
                        </div>
                    </form>
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

    <div class="row">
        <div class="col-md-6">
            <div class="template-demo">
                <button data-toggle="modal" data-target="#addModal" class="btn btn-info btn-icon-text">
                    <i class="mdi mdi-account-plus btn-icon-prepend"></i> Tambah Users </button>
            </div>
        </div>
    </div><br>
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
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Cari Username</badge>
                                <input type="text" class="form-control" name="cari" placeholder="Cari Username" value="">
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
                                    <th> ID Nama </th>
                                    <th> Email </th>
                                    <th> Username </th>
                                    <th> Saldo </th>
                                    <th> Pemakaian Saldo </th>
                                    <th> Level </th>
                                    <th> Api Key </th>
                                    <th> Status </th>
                                    <th> Aksinya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));

                                    $cek_users = "SELECT * FROM users WHERE username LIKE '%$cari_username%' AND status LIKE '%$cari_status%' ORDER BY id ASC"; // edit
                                } else {
                                    $cek_users = "SELECT * FROM users ORDER BY id ASC"; // edit
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
                                $new_query = $cek_users . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_pengguna = $new_query->fetch_assoc()) {
                                    if ($data_pengguna['status'] == "Aktif") {
                                        $badge = "success";
                                    } else if ($data_pengguna['status'] == "Tidak Aktif") {
                                        $badge = "danger";
                                    }
                                ?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $data_pengguna['id']; ?>" class="form-inline" role="form" method="POST">
                                            <td>[<?php echo $data_pengguna['id']; ?>] <?php echo $data_pengguna['nama']; ?></td>
                                            <td><?php echo $data_pengguna['email']; ?></td>
                                            <td><?php echo $data_pengguna['username']; ?></td>
                                            <td>Rp <?php echo number_format($data_pengguna['saldo'], 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($data_pengguna['pemakaian_saldo'], 0, ',', '.'); ?></td>
                                            <td><?php echo $data_pengguna['level']; ?></td>
                                            <td style="min-width: 200px;">
                                                <div class="input-group">
                                                    <button type="submit" name="change_api" class="btn btn-xs btn-bordred btn-success"><i class="mdi mdi-shuffle-variant" title="Ganti API Key"></i></button>
                                                    <input type="text" class="form-control form-control-sm" value="<?php echo $data_pengguna['api_key']; ?>" id="apikey-<?php echo $data_pengguna['id']; ?>" readonly="">
                                                    <button data-toggle="tooltip" title="Copy Apikey" class="btn btn-xs btn-primary" type="button" onclick="copy_to_clipboard('apikey-<?php echo $data_pengguna['id']; ?>')"><i class="mdi mdi-content-copy"></i></button>
                                                </div>
                                            </td>
                                            <td>
                                                <badge class="badge badge-outline-<?php echo $badge; ?>"><?php echo $data_pengguna['status']; ?></badge>
                                            </td>
                                            <td>
                                                <a href="javascript:;" onclick="users('/admin/ajax/pengguna/view.php?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-xs btn-info"><i class="mdi mdi-eye" title="View"></i> View </a>
                                                <a href="javascript:;" onclick="users('/admin/ajax/pengguna/edit.php?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-xs btn-warning"><i class="mdi mdi-border-color" title="Edit"></i> Edit </a>
                                                <a href="javascript:;" onclick="users('/admin/ajax/pengguna/delete.php?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-xs btn-danger"><i class="mdi mdi-delete" title="Hapus"></i> Delete </a>
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
                            $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                            $cari_status = $conn->real_escape_string(filter($_GET['status']));
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $self = $_SERVER['PHP_SELF'];
                        }
                        $cek_users = $conn->query($cek_users);
                        $total_records = mysqli_num_rows($cek_users);
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
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_username . "'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_username . "'><</a></li>";
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
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_username . "'>" . $i . "</a></li>";
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
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_status = $conn->real_escape_string(filter($_GET['status']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_username . "'>></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "&tampil=" . $cari_urut . "&status=" . $cari_status . "&cari=" . $cari_username . "'>>></a></li>";
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
                <h4 class="modal-title"><i class="mdi mdi-account-check"></i> Detail Pengguna</h4>
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