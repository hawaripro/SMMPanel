<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['update'])) {
    $get_id = $conn->real_escape_string($_GET['idkat']);
    $nama = $conn->real_escape_string(trim($_POST['nama']));
    
     $cek_Dtkategori = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$get_id'");
     $data_Dtkategori = $cek_Dtkategori->fetch_array(MYSQLI_ASSOC);
     
    if (!$nama) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nama Kategori Tidak Boleh Kosong');
    } else if ($cek_Dtkategori->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Data Kategori Tidak Ditemukan');
    } else {
        if ($conn->query("UPDATE kategori_layanan SET nama = '$nama', kode = '$nama' WHERE id = '$get_id'") == true) {
            $conn->query("UPDATE layanan_sosmed SET kategori = '$nama' WHERE id_kategori = '$get_id'");
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => '
                        Kategori Baru Telah Berhasil Diubah <br />
                        Nama Kategori Baru : ' . $nama . ' ');
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['hapus'])) {
    $get_id = $conn->real_escape_string($_GET['idkat']);
    $cek_Dtkategori = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$get_id'");

    if ($cek_Dtkategori->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Data Kategori Tidak Ditemukan.');
    } else {
        if ($conn->query("DELETE FROM kategori_layanan WHERE id = '$get_id'") == true) {
            $conn->query("DELETE FROM layanan_sosmed WHERE id_kategori = '$get_id'");
            
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Kategori Berhasil Di Hapus'
            );
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['tambah'])) {
    $post_kategori = $conn->real_escape_string($_POST['nama_kategori']);
    
    $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE nama = '$post_kategori'");
    
    if ($cek_kategori->num_rows == 1) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nama Kategori Sama Ditemukan. Coba Nama Yang Lain');
    } else if (!$post_kategori) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Kategori Tidak Boleh Kosong.');
    } else {
        if ($conn->query("INSERT INTO kategori_layanan VALUES ('', '$post_kategori', '$post_kategori', 'Sosial Media')") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Kategori Berhasil Di Ditambahkan'
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
    <!--MODAL-->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kategori Baru</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Kategori</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori Baru">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info btn-bordred waves-effect w-md waves-light" name="tambah">Tambah Kategori Baru</button>
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
                <button data-toggle="modal" data-target="#addModal" class="btn btn-info btn-icon-text">Tambah Kategori </button>
                <a href="/cronsjob/delete-kategori" class="btn btn-danger btn-icon-text">Hapus Semua Kategori</a>
                <p><code>*WARNING..!!! menghapus semua kategori akan menghapus semua ( layanan & Kategori ).!</code></p>
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
                                <badge>Pilih Kategori</badge>
                                <select class="form-control" name="id_kategori">
                                    <option value="">Pilih kategori...</option>
                                    <?php
                                    $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                    while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $data_kategori['id']; ?>"><?php echo $data_kategori['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <badge>Cari Nama Kategori</badge>
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
                                    <th> ID </th>
                                    <th> Ubah Nama Kategori </th>
                                    <th> Kode </th>
                                    <th> Aksinya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_kategorinya = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));

                                    $cek_kategori = "SELECT * FROM kategori_layanan WHERE nama LIKE '%$cari_kategorinya%' AND id LIKE '%$cari_id_kategori%' ORDER BY id ASC"; // edit
                                } else {
                                    $cek_kategori = "SELECT * FROM kategori_layanan ORDER BY id ASC"; // edit
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
                                $new_query = $cek_kategori . " LIMIT $starting_position, $records_per_page";
                                $new_query = $conn->query($new_query);
                                // end paging config
                                while ($data_kategori = $new_query->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?idkat=<?php echo $data_kategori['id']; ?>" class="form-inline" role="form" method="POST">
                                            <td>[<?php echo $data_kategori['id']; ?>]</td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 400px;" name="nama" value="<?php echo $data_kategori['nama']; ?>">
                                            </td>
                                            <td>
                                            <?php echo $data_kategori['kode']; ?>
                                            </td>
                                            <td>
                                                <button data-toggle="tooltip" title="Update" type="submit" name="update" class="btn btn-xs btn-bordred btn-info"><i class="mdi mdi-border-color"></i> Update </button>
                                                <button data-toggle="tooltip" title="Update" type="submit" name="hapus" class="btn btn-xs btn-bordred btn-danger"><i class="mdi mdi-broom"></i> Hapus </button>
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
                            $cari_kategorinya = $conn->real_escape_string(filter($_GET['cari']));
                            $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                            $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                        } else {
                            $self = $_SERVER['PHP_SELF'];
                        }
                        $cek_kategori = $conn->query($cek_kategori);
                        $total_records = mysqli_num_rows($cek_kategori);
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
                                    $cari_kategorinya = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_kategorinya . "'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_kategorinya . "'><</a></li>";
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
                                    $cari_kategorinya = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_kategorinya . "'>" . $i . "</a></li>";
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
                                    $cari_kategorinya = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_kategorinya . "'>></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_kategorinya . "'>>></a></li>";
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