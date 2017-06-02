<?php

$random = fopen('/dev/urandom', 'r');
$bytes = fread($random, 128);

echo '$secret = "';

for ($i = 0; $i < strlen($bytes); $i ++) {
	printf('\\x%02x', ord($bytes[$i]));
}

echo '";' . "\n";
