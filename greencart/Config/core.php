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
 * This is core configuration file. Use it to configure core behavior of Cake.
 */

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 */
Configure::write('debug', 2);

/**
 * Configure the Error handler used to handle errors for your application.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors.
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
Configure::write('Error', array(
	'handler' => 'ErrorHandler::handleError',
	'level'   => E_ALL & ~E_DEPRECATED,
	'trace'   => true
));

/**
 * Configure the Exception handler used for uncaught exceptions.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions.
 * - `renderer` - string - The class responsible for rendering uncaught exceptions.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
Configure::write('Exception', array(
	'handler'  => 'ErrorHandler::handleException',
	'renderer' => 'ExceptionRenderer',
	'log'      => true
));

/**
 * Application wide charset encoding.
 */
Configure::write('App.encoding', 'UTF-8');

/**
 * Prefix for admin routes.
 */
Configure::write('Routing.prefixes', array('admin'));

/**
 * Turn off all caching application-wide.
 */
//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 */
//Configure::write('Cache.check', true);

/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
define('LOG_ERROR', 2);

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration.
 *
 * Options:
 *
 * - `Session.cookie` - The name of the cookie to use.
 * - `Session.timeout` - The number of minutes you want sessions to live for (this timeout is
 *    handled by CakePHP).
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions?
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 * - `Session.handler` - Can be used to enable a custom session handler.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 */
Configure::write('Session', array(
	'cookie'         => 'GCSID',
	'cookieTimeout'  => 1440,
	'timeout'        => 1440,
	'checkAgent'     => true,
	'autoRegenerate' => true,
	'defaults'       => 'database',
	'handler'        => array('model' => 'Session')
));

/**
 * The level of CakePHP security.
 */
Configure::write('Security.level', 'medium');

/**
 * A random string used in security hashing methods.
 */
Configure::write('Security.salt',
	'Fjr"UJ0BFVW5~t8e\C[)_fYKhyun?|g:' . 'Nr{z2^v|<`I&"akW&.Cn%eAhVn~Ix#g0' .
	'&8Q})V>Pde$:$03W36"~P!gio6OHY-2p' . 'J/\TkdrG}~~ZEk5XM"B(&.uv^gfkssKB' .
	'hU1XRjN:#?m<Er[P2gYa_$w?axu47-N2' . 'aZIW?t?<}da0+R"Aq_\a#8JF8V6*dci[' .
	'+qGSv)mO~HY9q0)]5DL5G"p`T/|?p<p%' . '(ZuQ>pd!ePcIUUb|T-bhtQ+OTwclN"|p'
);

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
Configure::write('Security.cipherSeed', '1283291548');
Configure::write('Security.cipherKey' , 'kJIsLwIdmTYpaKhRgJaMlaeWqfghQcZd');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
Configure::write('Asset.timestamp', true);

/**
 * The classname and database used in CakePHP's access control lists.
 */
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');

/**
 * Sets the default timezone used by all date/time functions.
 */
date_default_timezone_set('UTC');

/**
 * Cache Engine Configuration
 */
$engine   = 'File';
$duration = Configure::read('debug') ? '+10 seconds' : '+999 days';

if (extension_loaded('apc') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine'    => $engine,
	'prefix'    => 'gc_core_',
	'path'      => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration'  => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine'    => $engine,
	'prefix'    => 'gc_model_',
	'path'      => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration'  => $duration
));
