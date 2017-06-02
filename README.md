# 🐙 Squid Password Emojifier

This tool encrypts a password or any text and outputs the result as a series of emojis. For example, `My5eCr3t` could be encrypted to something like this:

> 😲😡💄🐲🙂🙏👨💑🐘👬😳😓🙄🐐💰🐌

This can then be decrypted to the original password.

[Demo](https://squid.monoxid.ch) - *Do not use this for real passwords*

## Setup

All you need is a webserver running PHP.
Generate a new secret key by running the following command:

```sh
php dev/make-key.php
```

Replace the default `$secret` in `inc/config.php` with the generated one to ensure that only you can encrypt/decrypt your password.

## Security

There is no user verification to keep it simple. Use `.htaccess` for a simple login or limit the access to your personal IP address.

The passwords are encrypted with `AES-256-CBC`. This allows to identify invalid emoji strings.
