<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('Controller', 'Controller');

/**
 * Application level Controller
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class AppController extends Controller
{
	/**
	 * A list of models this controller uses.
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * A list of components this controller uses.
	 *
	 * @var array
	 */
	public $components = array(
		'Session', 'Cookie', 'Security', 'Auth', 'RequestHandler'
	);

	/**
	 * A list of helpers this controller uses.
	 *
	 * @var array
	 */
	public $helpers = array(
		'Session', 'Html', 'Form', 'Js'
	);

	/**
	 * The name of the View class this controller sends output to.
	 *
	 * @var string
	 */
	public $viewClass = 'Twig';

	/**
	 * The name of the View theme this controller uses.
	 *
	 * @var string
	 */
	public $theme = 'greencart';

	/**
	 * File extension for view templates.
	 *
	 * @var string
	 */
	public $ext = '.twig';

	/**
	 * Called before the controller action.
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		$this->Auth->allow('*');
	}

	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @return void
	 */
	public function beforeRender() {}

	/**
	 * Called after the controller action is run and rendered.
	 *
	 * @return void
	 */
	public function afterFilter() {}
}
