<?php

// https://en.wikipedia.org/wiki/Emoji

define('UNICODE_MAX_VALUE', 0x10FFFF);

$ranges = [
	[0x1F600, 0x1F64F],
	[0x1F400, 0x1F49F],
	[0x1F4B0, 0x1F4EF],
	[0x1F500, 0x1F52F],
	[0x1F680, 0x1F6B0],
];

header('Content-Type: text/plain');

$symbols = array();

foreach ($ranges as $range) {
	list($from, $to) = $range;

	for ($value = $from; $value <= $to; $value ++) {
		$bytes = '';

		if ($value < 0x80) {
			$bytes .= chr($value);
		}
		else if ($value < 0x800) {
			$bytes .= chr(0xC0 | ($value >> 6));
			$bytes .= chr(0x80 | ($value & 0x3F));
		}
		else if ($value < 0x10000) {
			$bytes .= chr(0xE0 | ($value >> 12));
			$bytes .= chr(0x80 | (($value >> 6) & 0x3F));
			$bytes .= chr(0x80 | ($value & 0x3F));
		}
		else if ($value <= UNICODE_MAX_VALUE) {
			$bytes .= chr(0xF0 | ($value >> 18));
			$bytes .= chr(0x80 | (($value >> 12) & 0x3F));
			$bytes .= chr(0x80 | (($value >> 6) & 0x3F));
			$bytes .= chr(0x80 | ($value & 0x3F));
		}
		else { // invalid
			$bytes = '�';
		}

		$symbols[$value] = $bytes;

		echo "$bytes";

		if (count($symbols) >= 256) {
			goto end;
		}
	}
}

end:

echo "\$symbols = [\n";

foreach ($symbols as $value => $symbol) {
	printf("\t0x%X => '%s',\n", $value, $symbol);
}

echo "];\n";
