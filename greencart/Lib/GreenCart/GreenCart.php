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
 * GreenCart Class
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class GreenCart
{
	/**
	 * Used to determine the current version of GreenCart.
	 */
	const VERSION = '0.1.0';

	/**
	 * Used to read configurations keys for GreenCart.
	 *
	 * @return mixed
	 */
	public static function conf($key)
	{
		return Configure::read(Configuration::CONFIG_KEY.'.'.$key);
	}
}
