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
 * URL Class
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Url
{
	/**
	 * Expands short notation of specified URL.
	 *
	 * @param mixed $url
	 * @return mixed
	 */
	public static function shortNotation($url)
	{
		if (is_string($url) && $url[0] === ':') {
			$url = self::parseShortNotation($url);
		} else if (isset($url[0][0]) && $url[0][0] === ':') {
			$url = self::parseShortNotation(array_shift($url)) + $url;
		}

		return $url;
	}

	/**
	 * Parses the short notation format for internal URLs.
	 *
	 * @param string $shortUrl
	 * @return array
	 */
	public static function parseShortNotation($shortUrl)
	{
		$url      = array();
		$params   = array('action', 'controller', 'plugin');
		$shortUrl = array_reverse(explode('.', ltrim($shortUrl, ':')));

		foreach ($shortUrl as $key => $value) {
			$url[$params[$key]] = $value;
		}

		return $url;
	}

	/**
	 * Adds i18n support to specified URL.
	 *
	 * @param mixed $url
	 * @return mixed
	 */
	public static function i18n($url)
	{
		$lang = Configure::read('Config.language');

		if (is_array($url)) {
			if ($lang != Configure::read('I18n.default')) {
				$url['lang'] = $lang;
			}
		} else if (is_string($url) && $url[0] === '/') {
			$split = explode('/', $url);
			$langs = Configure::read('I18n.languages');
			if (!in_array($split[1], $langs)) {
				if ($lang != Configure::read('I18n.default')) {
					$url = rtrim('/'.$lang.$url, '/');
				}
			}
		}

		return $url;
	}

	/**
	 * Checks whether an URL exists.
	 *
	 * @param string $url
	 * @return bool
	 */
	public static function exists($url)
	{
		return is_array(@get_headers($url));
	}
}
