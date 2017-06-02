<?php

require 'inc/config.php';
require 'inc/functions.php';

$password = null;
$emojiPassword = null;
$encrypt = false;
$error = false;

if (@$_POST['action'] == 'encrypt') {
	$password = trim(@$_POST['password']);

	if ($password) {
		// assume emoji string; decrypt
		if (in_array(substr($password, 0, 4), $symbols) || preg_match('/^\:([^\:\s]+)\:/', $password)) {
			$iv = substr(sha1($secret), 0, 16);

			$password = preg_replace_callback('/\:([^\:\s]+)\:/', function ($match) use ($shortcuts) {
				$name = $match[1];

				return $shortcuts[$name];
			}, $password);

			// remove whitespace
			$password = preg_replace('/\s+/', '', $password);

			// TODO: use better iv
			$emojiPassword = password_decrypt($password, $secret, $iv);
			$encrypt = false;

			if (!$emojiPassword) {
				$error = true;
			}
		}
		// assum password; encrypt
		else {
			$iv = substr(sha1($secret), 0, 16);

			// TODO: use better iv
			$emojiPassword = password_encrypt($password, $secret, $iv);
			$encrypt = true;
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>🐙 Password Emojifier</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="page-wrapper">
	<div class="page">
		<h1>🐙<br />Password Emojifier</h1>
		<div class="text-block">
			<p>The squid will encrypt your password with some fancy cryptographic algorithm and output the result as emojis.</p>
			<p>This way, the password can be stored anywhere, but nobody can read it! (Unless he has access to this tool)</p>
		</div>

		<form method="post" id="form">
			<div class="form-element">
				<textarea name="password" placeholder="Password to encrypt or emojis to decrypt" id="password" autocomplete="off" spellcheck="false"><?=htmlspecialchars($password)?></textarea>
				<div class="small">Leading or trailing whitespace will be removed.</div>
			</div>
			<div class="form-element"><input type="submit" value="Encrypt" data-state1="Encrypt" data-state2="Decrypt" disabled /></div>
			<input type="hidden" name="action" value="encrypt" />
		</form>

		<?php if ($emojiPassword) { ?>
		<div class="result delayed pushed-away">
			<?php 	if ($encrypt) { ?>
			<p>This is your encrypted password. Paste it back into the field above to decrypt it.</p>
			<?php 	} else { ?>
			<p>This is your decrypted password:</p>
			<?php 	} ?>
			<div class="form-element"><textarea id="emojis" readonly autocomplete="off" spellcheck="false"><?=htmlspecialchars($emojiPassword)?></textarea></div>
		</div>
		<?php } ?>
		<?php if ($error) { ?>
		<div class="result delayed pushed-away">
			<p class="error">Oh no! The emojis refused to be decrypted. Maybe you forgot one?</p>
		</div>
		<?php } ?>

	</div>
	<div class="disclaimer">
		<p class="small">The squid does not store your password in any way.<br />Copyright © 2016 monoxid.net</p>
	</div>
</div>

<script src="js/value-observer.js"></script>
<script src="js/main.js"></script>

</body>
</html>
