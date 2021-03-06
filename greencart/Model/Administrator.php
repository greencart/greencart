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
 * Administrator Model
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Administrator extends AppModel
{
	/**
	 * List of behaviors to load when the model object is initialized.
	 *
	 * @var array
	 */
	public $actsAs = array('User');
}
