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
 * The Front Controller for handling every request.
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors',  true);

/**
 * Use the DS to separate the directories in other defines.
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The full path to the directory which holds the application, WITHOUT a trailing DS.
 */
define('ROOT', dirname(dirname(__FILE__)));

/**
 * The actual directory name of the application.
 */
define('APP_DIR', 'greencart');

/**
 * Editing below this line should NOT be necessary.
 */
define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT',    dirname(__FILE__).DS);
define('TMP',         ROOT.DS.'tmp'.DS);

ini_set('include_path', ROOT.DS.'vendors'.DS.'cakephp'.DS.'lib'.PATH_SEPARATOR.ini_get('include_path'));

include('Cake'.DS.'bootstrap.php');

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/favicon.ico') {
	return;
}

App::uses('Dispatcher', 'Routing');

$Dispatcher = new Dispatcher();
$Dispatcher->dispatch(
	new CakeRequest(),
	new CakeResponse(array('charset' => Configure::read('App.encoding')))
);
