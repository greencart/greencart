<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Make a string's first character lowercase.
 *
 * @param string $str
 * @return string
 */
if (!function_exists('lcfirst')) {
	function lcfirst($str)
	{
		if (is_string($str) && isset($str[0])) {
			$str[0] = strtolower($str[0]);
		}
		return $str;
	}
}

/**
 * Generates a random string.
 *
 * @param string $type Type of the random string.
 * @param int $length Length of the random string.
 * @return string
 */
function str_rand($type = null, $length = 10)
{
	if (!empty($type)) {
		switch ($type) {
			case 'alnum' :
				$charset = array_merge(range(48, 57), range(65, 90), range(97, 122));
				break;
			case 'alpha' :
				$charset = array_merge(range(65, 90), range(97, 122));
				break;
			case 'graph' :
			case 'print' :
				$charset = range(33, 126);
				break;
			case 'lower' :
				$charset = range(97, 122);
				break;
			case 'upper' :
				$charset = range(65, 90);
				break;
			case 'digit' :
				$charset = range(48, 57);
				break;
			case 'xdigit' :
				$charset = array_merge(range(48, 57), range(97, 102));
				break;
			default : return false;
		}
	} else {
		$charset = range(0, 255);
	}
	for ($result = '', $i = 0; $i < $length; $i++) {
		$result .= chr($charset[array_rand($charset)]);
	}
	return $result;
}

/**
 * Array to Object conversion.
 *
 * @param array $array
 * @return object
 */
function array2object($array)
{
	return is_array($array) ? (object)array_map(__FUNCTION__, $array) : $array;
}

/**
 * Object to Array conversion.
 *
 * @param object $object Object to be converted to array.
 * @return array The result of conversion.
 */
function object2array($object)
{
	return is_object($object) ? array_map(__FUNCTION__, (array)$object) : $object;
}

/**
 * Convert hexadecimal string into binary data.
 *
 * @param string $str Hexadecimal string.
 * @return string Binary data.
 */
function hex2bin($str)
{
	if (strlen($str) % 2 == 1 || !preg_match('/^[0-9a-f]+$/i', $str)) {
		return false;
	}
	return implode('', array_map('chr', array_map('hexdec', str_split($str, 2))));
}
