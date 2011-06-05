#!/usr/bin/php -q
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
 * Command-line code generation utility to automate programmer chores.
 *
 * Shell dispatcher class
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 */
define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(dirname(dirname(__FILE__))) . DS . 'vendors' . DS . 'cakephp' . DS . 'lib'. DS . 'Cake' . DS . 'Console' . DS . 'ShellDispatcher.php');

return ShellDispatcher::run($argv);
