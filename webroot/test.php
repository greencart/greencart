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

if (!Configure::read('debug')) {
	header('HTTP/1.1 404 Not Found');
	exit;
}

require_once CAKE.'TestSuite'.DS.'CakeTestSuiteDispatcher.php';

CakeTestSuiteDispatcher::run();
