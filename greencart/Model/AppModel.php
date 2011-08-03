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
	 * List of behaviors to load when the model object is initialized.
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Containable', 'CustomValidation'
	);

	/**
	 * Name of the validation string domain to use when translating validation errors.
	 *
	 * @var string
	 */
	public $validationDomain = 'validation';

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

	/**
	 * Sanitizes given array or value for safe input.
	 *
	 * @param mixed $data Data to sanitize
	 * @param mixed $options Set of options
	 * @return mixed Sanitized data
	 */
	public static function clean($data, $options = array())
	{
		if (empty($data)) {
			return $data;
		}
		$options += array(
			'trim'       => true,
			'odd_spaces' => true,
			'carriage'   => true
		);
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = AppModel::clean($value, $options);
			}
		} else {
			if ($options['trim']) {
				$data = trim($data);
			}
			if ($options['odd_spaces']) {
				$data = str_replace(chr(0xCA), '', $data);
			}
			if ($options['carriage']) {
				$data = str_replace("\r", '', $data);
			}
		}

		return $data;
	}
}
