<?php

/*
 * This file is part of the MobotixTools package.
 *
 * Copyright (c) 2011 MobotixTools.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('ModelBehavior', 'Model');

/**
 * Cryptable Behavior
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class CryptableBehavior extends ModelBehavior
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
						$results[$key][$model->alias][$field] = decipher(
							$result[$model->alias][$field]
						);
					}
				}
			}
		} else {
			foreach ($this->settings[$model->alias]['fields'] as $field) {
				if (isset($results[$field])) {
					$results[$field] = decipher($results[$field]);
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
				$model->data[$model->alias][$field] = cipher(
					$model->data[$model->alias][$field]
				);
			}
		}

		return true;
	}
}
