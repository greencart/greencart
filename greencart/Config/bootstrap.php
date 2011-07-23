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

App::build(array(
	'locales'   => array(ROOT.DS.'languages'.DS),
	'plugins'   => array(ROOT.DS.'plugins'.DS),
	'GreenCart' => array(APP.'Lib'.DS.'GreenCart'.DS)
));

App::uses('GreenCart', 'GreenCart');

App::import('Lib', 'functions');

/**
 * Setup a 'default' cache configuration for use in the application.
 */
Cache::config('default', array('engine' => 'File', 'prefix' => 'gc_'));

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
Configure::write('Twig', array(
	'debug'            => (bool) Configure::read('debug'),
	'charset'          => strtolower(Configure::read('App.encoding')),
	'cache'            => CACHE.'views'.DS.'twig',
	'strict_variables' => (bool) Configure::read('debug'),
	'autoescape'       => false
));
