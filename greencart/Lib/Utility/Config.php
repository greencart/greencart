<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('I18n', 'I18n');
App::uses('Configuration', 'Model');

/**
 * Config Class
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Config
{
	/**
	 * Initializes configuration data.
	 *
	 * @param object $controller An instance to the current Controller object.
	 * @return void
	 */
	public static function init(Controller $controller)
	{
		// Multilanguage configuration

		if (!empty($controller->request->params['lang'])) {
			Configure::write('Config.language', $controller->request->params['lang']);
		}
		I18n::getInstance()->l10n->get(Configure::read('Config.language'));

		// General configuration

		if (Configure::read('debug') || !($data = Cache::read(Configuration::CACHE_KEY))) {
			$data = $controller->Configuration->getParams();
			Cache::write(Configuration::CACHE_KEY, $data);
		}

		Configure::write(Configuration::CONFIG_KEY, $data);
	}

	/**
	 * Used to read configurations keys.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public static function get($key)
	{
		return Configure::read(Configuration::CONFIG_KEY.'.'.$key);
	}
}
