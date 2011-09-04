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
 * Database configuration class. You can specify multiple configurations for production,
 * development and testing.
 *
 * Options:
 *
 * - `driver` - The name of a supported driver, as follows:
 *         Datasabe/Mysql     - MySQL 4 & 5,
 *         Datasabe/Sqlite    - SQLite (PHP5 only),
 *         Datasabe/Postgres  - PostgreSQL 7 and higher,
 *         Database/Sqlserver - Microsoft SQL Server 2005 and higher
 *
 * - `persistent` - Determines whether or not the database should use a persistent connection.
 *
 * - `host` -The host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * - `prefix` - Uses the given prefix for all the tables in this database.
 *
 * - `schema` - For Postgres specifies which schema you would like to use the tables in.
 *
 * - `encoding` - For MySQL, Postgres specifies the character encoding to use when connecting to the
 *   database. Uses database default if not specified.
 *
 * @author CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 */
class DATABASE_CONFIG
{
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'root',
		'password'   => 'password',
		'database'   => 'greencart',
		'prefix'     => 'gc_',
		'encoding'   => 'utf8'
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'root',
		'password'   => 'password',
		'database'   => 'greencart_test',
		'prefix'     => 'gc_test_',
		'encoding'   => 'utf8'
	);
}
