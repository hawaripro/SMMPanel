<?php
require("../config.php");

$json = file_get_contents("php://input");
    
    $data = json_decode($json);
    $merchantRef = $data->id_reference ;
    if ($data->status == 'success') {
        

        $ctrx = $conn->query("SELECT * FROM deposit WHERE merchant_ref = '".$merchantRef."' AND status = 'Pending'");
        
        if ($ctrx->num_rows == 1) {
        
            $trx = $ctrx->fetch_assoc();
            
            $get_saldo = $trx['get_saldo'];
            $kode_deposit = $trx['kode_deposit'];

            $conn->query("UPDATE deposit SET status = 'Success' WHERE id = '".$trx['id']."'");
            
            $conn->query("UPDATE users SET saldo = saldo+$get_saldo WHERE username = '".$trx['username']."'");
            
            $conn->query("INSERT INTO history_saldo VALUES ('', '".$trx['username']."', 'Penambahan Saldo', '$get_saldo', 'Mendapatkan Saldo Isi Saldo Via ".$trx['tipe']." ".$trx['provider']." Dengan Kode Isi Saldo : $kode_deposit', '$date', '$time')");
            
            exit();
        } else {
            exit();
        }
    } else if ($data->status == 'kadaluarsa'){ 
          $ctrx = $conn->query("SELECT * FROM deposit WHERE merchant_ref = '".$merchantRef."' AND status = 'Pending'");
        
        if ($ctrx->num_rows == 1) {
        
            $trx = $ctrx->fetch_assoc();

            $conn->query("UPDATE deposit SET status = 'Error' WHERE id = '".$trx['id']."'");
           
            exit();
        } else {
            exit();
        }  
    } else {
    
        exit();
        
    }

?>