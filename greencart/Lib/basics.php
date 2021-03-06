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
 * Returns a string with all spaces converted to hyphens (by default), accented
 * characters converted to non-accented characters, and non word characters removed.
 *
 * @param string $string
 * @param string $replacement
 * @return string
 */
function slugize($string, $replacement = '-')
{
	return strtolower(Inflector::slug($string, $replacement));
}

/**
 * Encrypts a text using the given key.
 *
 * @param string $str Normal string to encrypt.
 * @param string $key Key to use.
 * @return string Encrypted string in hexadecimal representation.
 */
function cipher($str, $key = null)
{
	if (!$key) {
		$key = Configure::read('Security.cipherKey');
	}
	return bin2hex(Security::cipher($str, $key));
}

/**
 * Decrypts a text using the given key.
 *
 * @param string $str Encrypted string to decrypt.
 * @param string $key Key to use.
 * @return string Decrypted string.
 */
function decipher($str, $key = null)
{
	if (!$key) {
		$key = Configure::read('Security.cipherKey');
	}
	if ($str = hex2bin($str)) {
		return Security::cipher($str, $key);
	}
	return false;
}
