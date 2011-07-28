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
 * Adds i18n support to specified URL.
 *
 * @param midex $url
 * @return mixed
 */
function i18n_url($url)
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
