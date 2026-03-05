<?php
	if (!isset($_SESSION['user'])) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Autentikasi dibutuhkan', 'pesan' => 'Silahkan Login.');
		exit(header("Location: ".$config['web']['url'].""));
	}