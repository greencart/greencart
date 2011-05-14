<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('AppModel', 'Model');

/**
 * Configuration Model
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Configuration extends AppModel
{
	const CACHE_KEY  = 'configuration';
	const CONFIG_KEY = '_GC_CONFIG';

	/**
	 * Table name for this model.
	 *
	 * @var string
	 */
	public $useTable = 'configuration';

	/**
	 * Gets a configuration parameter directly from database.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key)
	{
		return $this->field('value', array('key' => $key));
	}

	/**
	 * Gets all configuration parameters.
	 *
	 * @return array
	 */
	public function getParams()
	{
		return $this->find('list', array('fields' => array('key', 'value')));
	}

	/**
	 * Updates specified configuration parameters if they exists.
	 *
	 * @param array $params A list of parameters.
	 * @return mixed A list of saved keys or false on failure.
	 */
	public function updateParams($params)
	{
		$data = $result = array();
		$ids  = $this->find('list', array('fields' => array('key', 'id')));

		foreach ($params as $key => $value) {
			if (isset($ids[$key]) && $value != Configure::read(Configuration::CONFIG_KEY.'.'.$key)) {
				$result[$key] = $value;
				$data[]       = array('id' => $ids[$key], 'value' => $value);
			}
		}
		if (!$data || $this->saveAll($data, array('validate' => false, 'atomic' => true))) {
			return $result;
		}

		return false;
	}

	/**
	 * Called after each successful save operation.
	 *
	 * @param bool $created True if this save created a new record.
	 * @return void
	 */
	public function afterSave($created)
	{
		Cache::clear();
	}

	/**
	 * Called after every deletion operation.
	 *
	 * @return void
	 */
	public function afterDelete()
	{
		Cache::clear();
	}
}
