<?php

define('ENCRYPT_METHOD', 'AES-256-CBC');

function password_encrypt($password, $secretKey, $iv) {
	global $symbols;

	$data = openssl_encrypt($password, ENCRYPT_METHOD, $secretKey, OPENSSL_RAW_DATA, $iv);

	$chars = array_values($symbols);

	$password = '';

	for ($i = 0; $i < strlen($data); $i ++) {
		$password .= $chars[ord($data[$i])];
	}

	return $password;
}

function password_decrypt($password, $secretKey, $iv) {
	global $symbols;

	$chars = array_flip($symbols);
	$index = array_flip(array_keys($symbols));

	$outPassword = '';

	for ($i = 0; $i < strlen($password); $i += 4) {
		$char = @$chars[substr($password, $i, 4)];
		$char = @$index[$char];

		$outPassword .= chr($char);
	}

	$data = openssl_decrypt($outPassword, ENCRYPT_METHOD, $secretKey, OPENSSL_RAW_DATA, $iv);

	return $data;
}
