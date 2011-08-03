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
 * CustomValidation Behavior
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class CustomValidationBehavior extends ModelBehavior
{
	/**
	 * "passwordConfirm" custom validation rule.
	 *
	 * Used to check if passwords are identical.
	 *
	 * @param object $model Model using this behavior.
	 * @param array $check Data to check.
	 * @return bool Return TRUE on success or FALSE on failure.
	 */
	public function passwordConfirm($model, $check)
	{
		if (isset($model->data[$model->alias]['password'])) {
			return $model->data[$model->alias]['password'] === $check['password_confirm'];
		}

		return false;
	}
}
