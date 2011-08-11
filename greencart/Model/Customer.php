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
 * Customer Model
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Customer extends AppModel
{
	/**
	 * List of behaviors to load when the model object is initialized.
	 *
	 * @var array
	 */
	public $actsAs = array('User', 'Serializable' => array('ip', 'vars'));

	/**
	 * List of validation rules.
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule'    => array('notEmpty'),
				'message' => array('customer_name_not_empty')
			),
			'maxLength' => array(
				'rule'    => array('maxLength', 40),
				'message' => array('customer_name_max_length', 40)
			)
		),
		'email' => array(
			'notEmpty' => array(
				'rule'    => array('notEmpty'),
				'message' => array('customer_email_not_empty')
			),
			'maxLength' => array(
				'rule'    => array('maxLength', 80),
				'message' => array('customer_email_max_length', 80)
			),
			'email' => array(
				'rule'    => array('email'),
				'message' => array('customer_email_email')
			),
			'isUnique' => array(
				'rule'    => array('isUnique'),
				'message' => array('customer_email_is_unique')
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule'    => array('notEmpty'),
				'message' => array('customer_password_not_empty')
			),
			'minLength' => array(
				'rule'    => array('minLength', 8),
				'message' => array('customer_password_min_length', 8)
			)
		),
		'password_confirm' => array(
			'passwordConfirm' => array(
				'rule'    => array('passwordConfirm'),
				'message' => array('customer_password_confirm_password_confirm')
			)
		),
/*
		'captcha' => array(
			'isValid' => array('rule' => array('equalTo', true), 'last' => true)
		),
		'agreed' => array(
			'isValid' => array('rule' => array('equalTo', '1'), 'last' => true)
		)
*/
	);
}
