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
 * Web Access Frontend for TestSuite
 */

set_time_limit(0);
ini_set('display_errors', 1);

/**
 * Use the DS to separate the directories in other defines.
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * The full path to the directory which holds "greencart", WITHOUT a trailing DS.
 */
define('ROOT', dirname(dirname(__FILE__)));

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

if (!Configure::read('debug')) {
	header('HTTP/1.1 404 Not Found');
	exit;
}

require_once CAKE.'TestSuite'.DS.'CakeTestSuiteDispatcher.php';

CakeTestSuiteDispatcher::run();
