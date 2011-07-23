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
 * The Front Controller for handling every request
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors',  true);

/**
 * Use the DS to separate the directories in other defines.
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The full path to the directory which holds "greencart", WITHOUT a trailing DS.
 */
define('ROOT', dirname(dirname(dirname(__FILE__))));

/**
 * The actual directory name for the "greencart".
 */
define('APP_DIR', 'greencart');

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT.DS.'vendors'.DS.'cakephp'.DS.'lib');

define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT',    dirname(__FILE__).DS);
define('TMP',         ROOT.DS.'tmp'.DS);
define('APP_PATH',    ROOT.DS.APP_DIR.DS);
define('CORE_PATH',   CAKE_CORE_INCLUDE_PATH.DS);

include(CORE_PATH.'Cake'.DS.'bootstrap.php');

if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/favicon.ico') {
	return;
}

App::uses('Dispatcher', 'Routing');

$Dispatcher = new Dispatcher();
$Dispatcher->dispatch(new CakeRequest());
