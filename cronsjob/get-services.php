<!--Viewport -->
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<h3>
    <div style="text-align: center;">
        <a href="/admin/kelola-layanan"><b>Kembali</b></a><br />
    </div>
</h3>

<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
$cek_provider = mysqli_query($conn, "SELECT * FROM `provider` WHERE `code` = 'ZAYNFLAZZ'");
$data_provider = mysqli_fetch_assoc($cek_provider);

if (mysqli_num_rows($cek_provider) != 0) {
    $api_key = $data_provider['api_key'];
    $url = $data_provider['link'];
    $keuntungan = $data_provider['profit'];
    $name_provider = $data_provider['code'];

    $postdata = "api_key=$api_key&action=layanan";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    //echo $chresult;
    curl_close($ch);
    $json_result = json_decode($chresult, true);
    //print_r($json_result);

    $no = 1;
    $indeks = 0;
    while ($indeks < count($json_result['data'])) {
        $id_provider = $json_result['data'][$indeks]['sid'];
        $kategori = $json_result['data'][$indeks]['kategori'];
        $layanan = $json_result['data'][$indeks]['layanan'];
        $price = $json_result['data'][$indeks]['harga'];
        $min = $json_result['data'][$indeks]['min'];
        $max = $json_result['data'][$indeks]['max'];
        $catatan = $json_result['data'][$indeks]['catatan'];
        $average = $json_result['data'][$indeks]['average'];
        $refill = $json_result['data'][$indeks]['refill'];
        $provider = $name_provider;
        $price_after = $price * $keuntungan;
        $profit_after = $price_after - $price;
        $status = "Aktif";
        $tipe = "Sosial Media";
        $indeks++;

        //INSERT KATEGORI KE DATABASE kategori_layanan
        $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE nama = '$kategori' AND tipe = '$tipe'");
        if (mysqli_num_rows($cek_kategori) > 0) {
            $check_data = $conn->query("SELECT * FROM kategori_layanan WHERE nama = '$kategori'");
            $get_data = mysqli_fetch_assoc($check_data);
            $post_cat = $get_data['id'];
        } else {
            $input_kategori = $conn->query("INSERT INTO kategori_layanan VALUES ('','$kategori','$kategori','$tipe')");

            $check_data = $conn->query("SELECT * FROM kategori_layanan WHERE nama = '$kategori'");
            $get_data = mysqli_fetch_assoc($check_data);
            $post_cat = $get_data['id'];
        }
        //INSERT UPDATE KE DATABASE layanan_sosmed
        $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE provider_id = '$id_provider' AND provider = '$provider'");
        $data_layanan = $cek_layanan->fetch_assoc();
        if (mysqli_num_rows($cek_layanan) > 0) {
            $update = mysqli_query($conn, "UPDATE layanan_sosmed SET average = '$average', harga = '$price_after', harga_api = '$price', profit = '$profit_after', status = '$status', refill = '$refill' WHERE provider_id = '$id_provider' AND provider = '$provider'");
            echo "<b>Layanan Sudah Ada & Harga Diupdate</b> <br/>
		Provider ID: $id_provider <br/>
		Kategori: $kategori <br/>
		Layanan: $layanan <br/>
		Min. Order: $min <br/>
		Max. Order: $max <br/>
		Catatan: $catatan <br/>
		Provider: $provider <br/>
		Harga Web: $price_after <br/>
		Harga Pusat: $price <br/>
		Profit : $profit_after <br/>
		Status: $status <br/>
		Tipe: $tipe <br/><br/>";
        } else {

            //REPLACE NAMA LAYANAN DI PROVIDER layanan_sosmed
            $layanan = strtr($layanan, array(
                'ZF' => 'NW',
                'Zaynflazz' => 'Zaynflazz',
                'ZAYNFLAZZ' => 'Zaynflazz',
                'ZaynFlazz' => 'Zaynflazz',
            ));

            $sid = $no++;
            $insert_layanan = $conn->query("INSERT INTO layanan_sosmed VALUES ('','$sid', '$post_cat' ,'$kategori' ,'$layanan' ,'$catatan', '$average' ,'$min' ,'$max' ,'$price_after' ,'$price', '$profit_after', '$status' ,'$id_provider' ,'$provider' ,'$tipe', '$refill')");
            if ($insert_layanan == TRUE) {
                echo "<b>Data Berhasil Disimpan</b> <br/>
			Provider ID: $id_provider <br/>
    		Kategori: $kategori <br/>
    		Layanan: $layanan <br/>
    		Min. Order: $min <br/>
    		Max. Order: $max <br/>
    		Catatan: $catatan <br/>
    		Provider: $provider <br/>
    		Harga Web: $price_after <br/>
    		Harga Pusat: $price <br/>
    		Profit : $profit_after <br/>
    		Status: $status <br/>
    		Tipe: $tipe <br/><br/>";
            } else {
                echo "Layanan Gagal Disimpan";
            }
        }
    }
}
?>