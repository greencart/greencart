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
 * CustomerHelper
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class CustomerHelper extends AppHelper implements ArrayAccess
{
	/**
	 * Session data for current customer.
	 *
	 * @var array
	 */
	protected $_customer;

	/**
	 * Called before the view file is rendered.
	 *
	 * @return void
	 */
	public function beforeRender()
	{
		$this->_customer = (array) AuthComponent::user();
	}

	/**
	 * Checks to see if a customer is logged in.
	 *
	 * @return bool
	 */
	public function loggedIn()
	{
		return (bool) $this->_customer;
	}

	/**
	 * Gets the current customer from the session.
	 *
	 * @param string $field Field to retrive. Leave null to get entire Customer record.
	 * @return mixed Customer record or null if no customer is logged in.
	 */
	public function get($field = null)
	{
		if (!$field) {
			return $this->_customer ? $this->_customer : null;
		}

		return isset($this->_customer[$field]) ? $this->_customer[$field] : null;
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
		return isset($this->_customer[$offset]) ? $this->_customer[$offset] : null;
	}

	/**
	 * Whether or not an offset exists.
	 *
	 * @param mixed $offset An offset to check for.
	 * @return mixed
	 */
	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->_customer);
	}
}
