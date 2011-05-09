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
		if (is_string($url) && $url[0] === ':') {
			$url = $this->__parseShortUrl($url);
		} else if (isset($url[0][0]) && $url[0][0] === ':') {
			$url = array_merge($url, $this->__parseShortUrl($url[0]));
			unset($url[0]);
		}

		return parent::url($url, $full);
	}

	/**
	 * Returns the current language.
	 *
	 * @return string
	 */
	public function lang()
	{
		return Configure::read('Config.language');
	}

	/**
	 * Parses the short format notation for internal URLs.
	 *
	 * @param string $shortUrl
	 * @return array
	 */
	private function __parseShortUrl($shortUrl)
	{
		$url      = array();
		$params   = array('action', 'controller', 'plugin');
		$shortUrl = array_reverse(explode('.', ltrim($shortUrl, ':')));

		foreach ($shortUrl as $key => $value) {
			$url[$params[$key]] = $value;
		}

		return $url;
	}

}
