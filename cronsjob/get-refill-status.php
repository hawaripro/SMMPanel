<?php
require("../config.php");
$cek_provider = $conn->query("SELECT * FROM provider WHERE code = 'ZAYNFLAZZ'");
$data_provider = $cek_provider->fetch_assoc();

$name_provide = $data_provider['code'];
$url = $data_provider['link'];


$cek_pesanan = $conn->query("SELECT * FROM refill_order WHERE status IN ('','Pending','Processing','In Progress','In progress') AND provider = '$name_provide'");

if (mysqli_num_rows($cek_pesanan) == 0) {
  die("Refill Pending Tidak Ditemukan.");
} else {
  while($data_pesanan = $cek_pesanan->fetch_assoc()) {
    $poid =  $data_pesanan['provider_id'];
    $oid =  $data_pesanan['oid'];

    if ($o_provider == "MANUAL") {
      echo "Order manual<br />";
    } else {


    
        $api_postdata = "api_key=".$data_provider['api_key']."&action=refill_status&id_refill=$poid";
     

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $chresult = curl_exec($ch);
      //echo $chresult;
      curl_close($ch);
      $json_result = json_decode($chresult, true);
      //print_r($json_result);
      $id =  $json_result['data']['id'];

     if ($json_result['data']['status'] == "Pending") {
				$u_status = "Pending";
			} else if ($json_result['data']['status'] == "Processing") {
				$u_status = "Processing";
			} else if ($json_result['data']['status'] == "In progress") {
				$u_status = "Processing";
			} else if ($json_result['data']['status'] == "In Progress") {
				$u_status = "Processing";
			} else if ($json_result['data']['status'] == "Canceled") {
				$u_status = "Canceled";	
			} else if ($json_result['data']['status'] == "Error") {
				$u_status = "Canceled";	
			} else if ($json_result['data']['status'] == "Rejected") {
				$u_status = "Ditolak";	
			} else if ($json_result['data']['status'] == "Awaiting") {
				$u_status = "Pending";	
			} else if ($json_result['data']['status'] == "Error") {
				$u_status = "Canceled";
			} else if ($json_result['data']['status'] == "Ditolak") {
				$u_status = "Ditolak";
			} else if ($json_result['data']['status'] == "Completed") {
				$u_status = "Completed";
			} else if ($json_result['data']['status'] == "Success") {
				$u_status = "Completed";
			}
		
      $update_pesanan = $conn->query("UPDATE refill_order SET status = '$u_status' WHERE provider_id = '$id' AND provider = '$name_provide'");
      
      if ($update_pesanan == TRUE) {
        echo "<b>Status Order Diupdate</b> <br/>
        Provider ID: $poid <br/>
        ID Web : $oid <br/>
        Status: $u_status <br/>
         ";
      } else {
        echo "Error database";
      }
    }
  }
}

?>