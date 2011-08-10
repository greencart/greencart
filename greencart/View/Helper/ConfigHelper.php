<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('AppHelper', 'View/Helper');

/**
 * ConfigHelper
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class ConfigHelper extends AppHelper implements ArrayAccess
{
	/**
	 * Used to read configurations keys.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		return Config::get($key);
	}

	/**
	 * Assigns a value to the specified offset.
	 *
	 * @param mixed $offset The offset to assign the value to.
	 * @param mixed $value The value to set.
	 * @return void
	 */
	public function offsetSet($offset, $value) {}

	/**
	 * Unsets an offset.
	 *
	 * @param mixed $offset The offset to unset.
	 * @return void
	 */
	public function offsetUnset($offset) {}

	/**
	 * Returns the value at specified offset.
	 *
	 * @param mixed $offset The offset to retrieve.
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return Config::get(strtoupper($offset));
	}

	/**
	 * Whether or not an offset exists.
	 *
	 * @param mixed $offset An offset to check for.
	 * @return mixed
	 */
	public function offsetExists($offset)
	{
		return true;
	}
}
