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

$routes = array(

	// Base path

	array(
		'template' => '/',
		'defaults' => array('controller' => 'pages', 'action' => 'display', 'home')
	),
);

$adminRoutes = array(

	// Base path

	array(
		'template' => '/admin',
		'defaults' => array('controller' => 'administrators', 'action' => 'dashboard')
	),
);

/**
 * Connecting routes using I18n mechanism.
 */
Router::parseExtensions('html', 'xml', 'rss', 'json', 'txt');
Router::connectNamed(false);

$i18n            = Configure::read('I18n');
$i18n['pattern'] = implode('|', $i18n['languages']);

foreach ($routes as $route) {
	$route    += array('defaults' => array(), 'options' => array());
	$i18nRoute = $route;

	$i18nRoute['template']         = rtrim('/:lang'.$i18nRoute['template'], '/');
	$i18nRoute['defaults']['lang'] = $i18n['default'];
	$i18nRoute['options']['lang']  = $i18n['pattern'];

	Router::connect($i18nRoute['template'], $i18nRoute['defaults'], $i18nRoute['options']);
	Router::connect($route['template'], $route['defaults'], $route['options']);
}

/**
 * Connecting admin routes.
 */
foreach ($adminRoutes as $route) {
	$route += array('defaults' => array(), 'options' => array());
	$route['defaults']['admin'] = true;
	Router::connect($route['template'], $route['defaults'], $route['options']);
}

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Connects the default, built-in routes, including prefix and plugin routes. The following routes
 * are created in the order below:
 *
 * For each of the Routing.prefixes the following routes are created. Routes containing `:plugin`
 * are only created when your application has one or more plugins.
 *
 * - `/:prefix/:plugin` a plugin shortcut route.
 * - `/:prefix/:plugin/:action/*` a plugin shortcut route.
 * - `/:prefix/:plugin/:controller`
 * - `/:prefix/:plugin/:controller/:action/*`
 * - `/:prefix/:controller`
 * - `/:prefix/:controller/:action/*`
 *
 * If plugins are found in your application the following routes are created:
 *
 * - `/:plugin` a plugin shortcut route.
 * - `/:plugin/:action/*` a plugin shortcut route.
 * - `/:plugin/:controller`
 * - `/:plugin/:controller/:action/*`
 *
 * And lastly the following catch-all routes are connected.
 *
 * - `/:controller'
 * - `/:controller/:action/*'
 */
$prefixes = Router::prefixes();

if ($plugins = CakePlugin::loaded()) {
	App::uses('PluginShortRoute', 'Routing/Route');

	foreach ($plugins as $key => $value) {
		$plugins[$key] = Inflector::underscore($value);
	}

	$pluginPattern = implode('|', $plugins);
	$match         = array('plugin' => $pluginPattern);
	$shortParams   = array('routeClass' => 'PluginShortRoute', 'plugin' => $pluginPattern);

	foreach ($prefixes as $prefix) {
		$params      = array('prefix' => $prefix, $prefix => true);
		$indexParams = $params + array('action' => 'index');
		Router::connect("/{$prefix}/:plugin", $indexParams, $shortParams);
		Router::connect("/{$prefix}/:plugin/:controller", $indexParams, $match);
		Router::connect("/{$prefix}/:plugin/:controller/:action/*", $params, $match);
	}
	Router::connect('/:plugin', array('action' => 'index'), $shortParams);
	Router::connect('/:plugin/:controller', array('action' => 'index'), $match);
	Router::connect('/:plugin/:controller/:action/*', array(), $match);
}

foreach ($prefixes as $prefix) {
	$params      = array('prefix' => $prefix, $prefix => true);
	$indexParams = $params + array('action' => 'index');
	Router::connect("/{$prefix}/:controller", $indexParams);
	Router::connect("/{$prefix}/:controller/:action/*", $params);
}

Router::connect(
	'/:lang/:controller',
	array('lang' => $i18n['default'], 'action' => 'index'),
	array('lang' => $i18n['pattern'])
);
Router::connect('/:controller', array('action' => 'index'));

Router::connect(
	'/:lang/:controller/:action/*',
	array('lang' => $i18n['default']),
	array('lang' => $i18n['pattern'])
);
Router::connect('/:controller/:action/*');
