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
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 */

Router::parseExtensions('html', 'xml', 'rss', 'json', 'txt');
Router::connectNamed(false);

$routes = array(

	// Base path

	'/' => array(
		array('controller' => 'pages', 'action' => 'display', 'home')
	),
);

$adminRoutes = array(

	// Base path

	'/admin' => array(
		array('controller' => 'administrators', 'action' => 'dashboard', 'admin' => true)
	),
);

foreach ($routes + $adminRoutes as $route => $options) {
	Router::connect($route, $options[0], isset($options[1]) ? $options[1] : array());
}

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE.'Config'.DS.'routes.php';
