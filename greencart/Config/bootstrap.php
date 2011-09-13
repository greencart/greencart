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
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 */

/**
 * Defining additional search paths. All paths should be terminated with a Directory separator.
 */
App::build(array(
	'locales'   => array(ROOT.DS.'languages'.DS),
	'plugins'   => array(ROOT.DS.'plugins'.DS),
	'GreenCart' => array(APP.'Lib'.DS.'GreenCart'.DS)
));

/**
 * Resolving imports
 */
App::uses('GreenCart', 'GreenCart');
App::uses('Config', 'Utility');
App::uses('Mcrypt', 'Utility');
App::uses('Url', 'Utility');

App::import('Lib', 'functions');
App::import('Lib', 'basics');

/**
 * Setup a 'default' cache configuration for use in the application.
 */
Cache::config('default', array('engine' => 'File', 'prefix' => 'gc_'));

/**
 * Multilanguage support settings.
 */
Configure::write('I18n', array(
	'languages' => array('en', 'ro'),
	'default'   => 'en',
	'fallback'  => 'en'
));

Configure::write('Config.language', Configure::read('I18n.default'));
define('DEFAULT_LANGUAGE', Configure::read('I18n.fallback'));

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them
 * in a single call.
 *
 * CakePlugin::loadAll();
 * CakePlugin::load('DebugKit');
 */
CakePlugin::loadAll();

/**
 * Twig Template Engine configuration
 *
 * @link http://www.twig-project.org/doc/api.html#environment-options
 */
Configure::write('Twig', array());
