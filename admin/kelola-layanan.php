<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
if (isset($_POST['update'])) {
    $get_id = $conn->real_escape_string($_POST['id']);
    $provider_id = $conn->real_escape_string(trim($_POST['provider_id']));
    $kategori = $conn->real_escape_string(trim($_POST['kategori']));
    $layanan = $conn->real_escape_string(trim($_POST['layanan']));
    $catatan = $conn->real_escape_string(trim($_POST['catatan']));
    $harga = $conn->real_escape_string(trim($_POST['harga']));
    $min = $conn->real_escape_string(trim($_POST['min']));
    $max = $conn->real_escape_string(trim($_POST['max']));
    $refill = $conn->real_escape_string(trim($_POST['refill']));
    $status = $conn->real_escape_string(trim($_POST['status']));
    $provider = $conn->real_escape_string(trim($_POST['provider']));

    $cek_Dtlayanan = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$get_id'");
    
    $cek_Dtktegori = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$kategori'");
    $data_Dtktegori = $cek_Dtktegori->fetch_array(MYSQLI_ASSOC);
    
    $ID_kategori = $data_Dtktegori['id'];
    $NM_kategori = $data_Dtktegori['nama'];

    if (!$layanan || !$harga || !$min || !$max) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Layanan/Harga/min/max Tidak Boleh Kosong');
    } else if ($cek_Dtlayanan->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Data Layanan Tidak Ditemukan');
    } else {
        if ($conn->query("UPDATE layanan_sosmed SET id_kategori = '$ID_kategori', kategori = '$NM_kategori', layanan = '$layanan', catatan = '$catatan', harga = '$harga', min = '$min', max = '$max', refill = '$refill', status = '$status', provider_id = '$provider_id', provider = '$provider' WHERE id = '$get_id'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Data Layanan Berhasil Diubah'
            );
        } else {
            $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Sistem Error !!');
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['hapus'])) {
    $get_id = $conn->real_escape_string($_GET['idkat']);
    $cek_Dtkategori = $conn->query("SELECT * FROM layanan_sosmed WHERE id = '$get_id'");

    if ($cek_Dtkategori->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal!', 'pesan' => 'Data Layanan Tidak Ditemukan.');
    } else {
        if ($conn->query("DELETE FROM layanan_sosmed WHERE id = '$get_id'") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Layanan Berhasil Di Hapus'
            );
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI'] . "");
    exit();
} else if (isset($_POST['tambah'])) {
    $post_provider_id = $conn->real_escape_string($_POST['provider_id']);
    $post_kategori = $conn->real_escape_string($_POST['kategori']);
    $post_layanan = $conn->real_escape_string($_POST['layanan']);
    $post_catatan = $conn->real_escape_string($_POST['catatan']);
    $post_harga = $conn->real_escape_string($_POST['harga']);
    $post_harga_api = $conn->real_escape_string($_POST['harga_api']);
    $post_profit = $conn->real_escape_string($_POST['profit']);
    $post_min = $conn->real_escape_string($_POST['min']);
    $post_max = $conn->real_escape_string($_POST['max']);
    $post_refill = $conn->real_escape_string($_POST['refill']);
    $post_provider = $conn->real_escape_string($_POST['provider']);
    
    $cek_Dtlayanan = $conn->query("SELECT * FROM layanan_sosmed ORDER BY id DESC");
    $data_Dtlayanan = $cek_Dtlayanan->fetch_array(MYSQLI_ASSOC);
    $ID_terakhir = $data_Dtlayanan['service_id']+1;

    $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$post_kategori'");
    $data_Dtktegori = $cek_kategori->fetch_array(MYSQLI_ASSOC);
    
    $ID_kategori = $data_Dtktegori['id'];
    $NM_kategori = $data_Dtktegori['nama'];

    if ($cek_kategori->num_rows == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Kategori Tidak Ditemukan.');
    } else if (!$post_provider_id || !$post_kategori || !$post_layanan || !$post_harga || !$post_harga_api || !$post_profit || !$post_min || !$post_max || !$post_provider) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Isi Semua Input Dengan Benar.');
    } else {
        if ($conn->query("INSERT INTO layanan_sosmed VALUES ('', '$ID_terakhir', '$ID_kategori', '$NM_kategori','$post_layanan','$post_catatan','Belum Ada Data','$post_min','$post_max','$post_harga','$post_harga_api','$post_profit','Aktif','$post_provider_id','$post_provider','Sosial Media','$post_refill')") == true) {
            $_SESSION['hasil'] = array(
                'alert' => 'success',
                'judul' => 'Berhasil',
                'pesan' => 'Layanan Berhasil Di Ditambahkan'
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
                    <h5>Total Layanan</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $layanan_total; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-flash text-info ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Layanan Aktif</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $layanan_aktif; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-flash-auto text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Layanan Tidak Aktif</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $layanan_Tidak_aktif; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-flash-off text-danger ml-auto"></i>
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
                    <h4 class="modal-title">Tambah Layanan Baru</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Provider ID</label>
                            <div class="col-sm-9">
                                <input type="number" name="provider_id" class="form-control" placeholder="Provider ID">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Kategori</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="kategori" id="kategori">
                                    <option value="">Pilih Kategori...</option>
                                    <?php
                                    $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                    while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $data_kategori['id']; ?>"><?php echo $data_kategori['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Layanan</label>
                            <div class="col-sm-9">
                                <input type="text" name="layanan" class="form-control" placeholder="Nama Layanan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Catatan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga Jual</label>
                            <div class="col-sm-9">
                                <input type="number" name="harga" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga provider</label>
                            <div class="col-sm-9">
                                <input type="number" name="harga_api" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Profit</label>
                            <div class="col-sm-9">
                                <input type="number" name="profit" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Min</label>
                            <div class="col-sm-9">
                                <input type="number" name="min" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Max</label>
                            <div class="col-sm-9">
                                <input type="number" name="max" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Refill<code>*jika bergaransi isi 1. jika tidak abaikan</code></label>
                            <div class="col-sm-9">
                                <input type="number" name="refill" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Provider</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="provider" id="provider">
                                <?php
                                $cek_provider = $conn->query("SELECT * FROM provider");
                                while ($data_provider = $cek_provider->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $data_provider['code']; ?>"><?php echo $data_provider['code']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info btn-bordred waves-effect w-md waves-light" name="tambah">Tambah Layanan Baru</button>
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
                <button data-toggle="modal" data-target="#addModal" class="btn btn-info btn-icon-text">Tambah Layanan </button>
                    <a href="/cronsjob/get-services" class="btn btn-success btn-icon-text">Get/Updated Layanan Provider</a>
                    <a href="/cronsjob/delete-layanan" class="btn btn-danger btn-icon-text">Hapus Semua Layanan</a>
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
                                <badge>Filter Kategori</badge>
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
                                <badge>Cari Nama layanan</badge>
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
                                    <th> Service ID </th>
                                    <th> Kategori</th>
                                    <th> Layanan </th>
                                    <th> Harga </th>
                                    <th> Harga Provider</th>
                                    <th> Min </th>
                                    <th> Max </th>
                                    <th> Provider </th>
                                    <th> Status </th>
                                    <th> Aksi Layanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // start paging config
                                if (isset($_GET['cari'])) {
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));

                                    $cek_kategori = "SELECT * FROM layanan_sosmed WHERE layanan LIKE '%$cari_username%' AND id_kategori LIKE '%$cari_id_kategori%' ORDER BY id ASC"; // edit
                                } else {
                                    $cek_kategori = "SELECT * FROM layanan_sosmed ORDER BY id ASC"; // edit
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
                                    if ($data_kategori['status'] == "Aktif") {
                                        $label = "success";
                                    } else if ($data_kategori['status'] == "Tidak Aktif") {
                                        $label = "danger";
                                    }
                                ?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?idkat=<?php echo $data_kategori['id']; ?>" class="form-inline" role="form" method="POST">
                                            <td><?php echo $data_kategori['service_id']; ?>
                                            </td>
                                            <td><?php echo $data_kategori['kategori']; ?>
                                            </td>
                                            <td><?php echo $data_kategori['layanan']; ?>
                                            </td>
                                            <td>Rp <?php echo number_format($data_kategori['harga'], 0, ',', '.'); ?>
                                            </td>
                                            <td>Rp <?php echo number_format($data_kategori['harga_api'], 0, ',', '.'); ?>
                                            </td>
                                            <td><?php echo $data_kategori['min']; ?>
                                            </td>
                                            <td><?php echo $data_kategori['max']; ?>
                                            </td>
                                            <td><?php echo $data_kategori['provider']; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $label; ?>"><?php echo $data_kategori['status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="javascript:;" onclick="users('/admin/ajax/layanan/view.php?id=<?php echo $data_kategori['id']; ?>')" class="btn btn-xs btn-info"><i class="mdi mdi-eye" title="View"></i> View </a>
                                                <a href="javascript:;" onclick="users('/admin/ajax/layanan/edit.php?id=<?php echo $data_kategori['id']; ?>')" class="btn btn-xs btn-warning"><i class="mdi mdi-border-color" title="Ubah"></i> Ubah </a>
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
                            $cari_username = $conn->real_escape_string(filter($_GET['cari']));
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
                                    $cari_username = $conn->real_escape_string(filter($_GET['cari']));
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=1&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_username . "'><<</a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $previous . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_username . "'><</a></li>";
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
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    if ($i == $current_page) {
                                        echo "<li class='active page-item'><a class='page-link' href='#'>" . $i . "</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $i . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_username . "'>" . $i . "</a></li>";
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
                                    $cari_id_kategori = $conn->real_escape_string(filter($_GET['id_kategori']));
                                    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $next . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_username . "'>></a></li>";
                                    echo "<li class='page-item'><a class='page-link' href='" . $self . "?halaman=" . $total_pages . "&tampil=" . $cari_urut . "&id_kategori=" . $cari_id_kategori . "&cari=" . $cari_username . "'>>></a></li>";
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
                <h4 class="modal-title">Detail Data Layanan</h4>
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