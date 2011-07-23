<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('Model', 'Model');

/**
 * Application level Model
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class AppModel extends Model
{
	const DATE_EMPTY = '0000-00-00 00:00:00';
	const DATE_SQL   = 'Y-m-d H:i:s';

	/**
	 * Returns a SQL formated date.
	 *
	 * @param mixed $timestamp Unix timestamp that defaults to the current local time.
	 * @return string SQL date based on specified timestamp.
	 */
	static function date($timestamp = null)
	{
		if ($timestamp === false) {
			return self::DATE_EMPTY;
		}
		return date(self::DATE_SQL, is_null($timestamp) ? time() : $timestamp);
	}
}
