<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('Helper', 'View');

/**
 * Application level Helper
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class AppHelper extends Helper
{
	/**
	 * Finds URL for specified action.
	 *
	 * @param mixed $url A string or array-based URL.
	 * @param bool $full If true, the full base URL will be prepended to the result.
	 * @return string Full translated URL with base path.
	 * @see Helper::url()
	 */
	public function url($url = null, $full = false)
	{
		// short notation

		$url = Url::shortNotation($url);

		// multilanguage support

		$url = Url::i18n($url);

		return parent::url($url, $full);
	}
}
