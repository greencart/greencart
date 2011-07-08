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
 * Autoloads Twig classes (modified by Sebastian Ionescu to support CakePHP).
 *
 * @package twig
 * @author  Fabien Potencier <fabien@symfony.com>
 */
class Twig_Autoloader
{
	/**
	 * Registers Twig_Autoloader as an SPL autoloader.
	 *
	 * @return void
	 */
	static public function register()
	{
		ini_set('unserialize_callback_func', 'spl_autoload_call');
		spl_autoload_register(array(new self, 'autoload'));
	}

	/**
	 * Handles autoloading of classes.
	 *
	 * @param  string  $class  A class name.
	 * @return boolean Returns true if the class has been loaded.
	 */
	static public function autoload($class)
	{
		if (0 !== strpos($class, 'Twig')) {
			return;
		}
		$paths = array(
			dirname(__FILE__).'/../',
			dirname(__FILE__).'/../../../vendors/twig/lib/',
		);
		foreach ($paths as $path) {
			if (file_exists($file = $path.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
				require $file;
				break;
			}
		}
	}
}
