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
 * Mcrypt Class
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Mcrypt
{
	/**
	 * Data encryption
	 *
	 * @param mixed $data The data to encrypt.
	 * @param string $key The key to use.
	 * @param bool $base64 Encode the result using Base64 algorithm.
	 * @return string Returns the encrypted data.
	 */
	public static function encrypt($data, $key = null, $base64 = true)
	{
		if (!($td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, ''))) {
			return false;
		}
		if (!$key) {
			$key = Configure::read('Security.cipherKey');
		}

		$key  = self::pbkdf2($key, Configure::read('Security.salt'));
		$data = serialize($data);
		$iv   = mcrypt_create_iv(32, MCRYPT_RAND);

		if (0 !== mcrypt_generic_init($td, $key, $iv)) {
			return false;
		}

		$data  = mcrypt_generic($td, $data);
		$data  = $iv.$data;
		$mac   = self::pbkdf2($data, $key);
		$data .= $mac;

		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		if ($base64) {
			$data = base64_encode($data);
		}

		return $data;
	}

	/**
	 * Data decryption
	 *
	 * @param string $data The data to decryption.
	 * @param string $key The key to use.
	 * @param bool $base64 Data is encoded using Base64 algorithm.
	 * @return string Returns the decrypted data.
	 */
	public static function decrypt($data, $key = null, $base64 = true)
	{
		if (!($td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, ''))) {
			return false;
		}
		if (!$key) {
			$key = Configure::read('Security.cipherKey');
		}
		if ($base64) {
			$data = base64_decode($data);
		}

		$key  = self::pbkdf2($key, Configure::read('Security.salt'));
		$iv   = substr($data, 0, 32);
		$dmac = substr($data, -32);
		$data = substr($data, 32, strlen($data) - 64);
		$mac  = self::pbkdf2($iv.$data, $key);

		if ($dmac !== $mac || 0 !== mcrypt_generic_init($td, $key, $iv)) {
			return false;
		}

		$data = mdecrypt_generic($td, $data);
		$data = unserialize($data);

		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		return $data;
    }

    /**
     * PBKDF2 Implementation (as described in RFC 2898)
     *
     * @param string $p The master password for which a derivation is generated.
     * @param string $s The salt.
     * @param int $c The number of iterations, positive integer (use 1000 or higher).
     * @param int $kl The derived key length.
     * @param string $algo A hash algorithm.
     * @return string The derived key.
     */
	public function pbkdf2($p, $s, $c = 1000, $kl = 32, $algo = 'sha256')
	{
		$hl = strlen(hash($algo, null, true));
		$kb = ceil($kl / $hl);
		$dk = null;

		for ($block = 1; $block <= $kb; $block++) {
			$ib = $b = hash_hmac($algo, $s.pack('N', $block), $p, true);
			for ($i = 1; $i < $c; $i++) {
				$ib ^= ($b = hash_hmac($algo, $b, $p, true));
			}
			$dk .= $ib;
		}

		return substr($dk, 0, $kl);
	}
}
