<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('AppController', 'Controller');

/**
 * PagesController for static content
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class PagesController extends AppController
{
	/**
	 * A list of models this controller uses.
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * Called before the controller action.
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();

		// Auth component settings

		$this->Auth->allow();
	}

	/**
	 * Displays a view
	 *
	 * @param mixed What page to display
	 */
	public function display()
	{
		$path  = func_get_args();
		$count = count($path);

		if (!$count) {
			$this->redirect('/');
		}

		$this->render(implode('/', $path));
	}
}
