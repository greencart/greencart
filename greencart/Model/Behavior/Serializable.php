<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('ModelBehavior', 'Model');

/**
 * Serializable Behavior
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class SerializableBehavior extends ModelBehavior
{
	/**
	 * Setup this behavior with the specified configuration settings.
	 *
	 * @param object $model Model using this behavior.
	 * @param array $config Configuration settings for $model.
	 */
	public function setup($model, $config = array())
	{
		$this->settings[$model->alias] = array('fields' => $config);
	}

	/**
	 * afterFind Callback
	 *
	 * @param object $model Model using this behavior.
	 * @param mixed $results The results of the find operation.
	 * @param boolean $primary Whether this model is being queried directly or as an association.
	 * @return mixed Result of the find operation.
	 */
	public function afterFind($model, $results, $primary)
	{
		if ($primary) {
			foreach ($results as $key => $result) {
				foreach ($this->settings[$model->alias]['fields'] as $field) {
					if (isset($result[$model->alias][$field])) {
						$results[$key][$model->alias][$field] = unserialize(
							$result[$model->alias][$field]
						);
					}
				}
			}
		} else {
			foreach ($this->settings[$model->alias]['fields'] as $field) {
				if (isset($results[$field])) {
					$results[$field] = unserialize($results[$field]);
				}
			}
		}

		return $results;
	}

	/**
	 * beforeSave Callback
	 *
	 * @param object $model Model using this behavior.
	 * @return mixed TRUE if the operation should abort or any other result to continue.
	 */
	public function beforeSave($model)
	{
		foreach ($this->settings[$model->alias]['fields'] as $field) {
			if (isset($model->data[$model->alias][$field])) {
				$model->data[$model->alias][$field] = serialize(
					$model->data[$model->alias][$field]
				);
			}
		}

		return true;
	}
}
