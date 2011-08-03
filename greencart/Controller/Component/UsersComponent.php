<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('Component', 'Controller');

/**
 * UsersComponent
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class UsersComponent extends Component
{
	/**
	 * Other components utilized by this component.
	 *
	 * @var array
	 */
	public $components = array('Auth');

	/**
	 * A reference to the instantiating controller object.
	 *
	 * @var object
	 */
	public $controller;

	/**
	 * initialize Callback
	 *
	 * Called before the Controller::beforeFilter().
	 *
	 * @param object $controller Controller with components to initialize.
	 * @return void
	 */
	public function initialize($controller)
	{
		$this->controller = $controller;
	}

	/**
	 * startup Callback
	 *
	 * Called after the Controller::beforeFilter() and before the controller action.
	 *
	 * @param object $controller Controller with components to startup.
	 * @return void
	 */
	public function startup($controller)
	{
		if (!$this->Auth->loggedIn()) {
			return;
		}
		if ($model = $this->__getUserModel()) {
			$model->id = $this->Auth->user('id');
			$model->save(array(
				$model->alias => array(
					'online' => AppModel::date()
				)
			));
		}
	}

	/**
	 * afterLogin Callback
	 *
	 * Updates user data after a successfull login.
	 *
	 * @return void
	 */
	public function afterLogin()
	{
		if (!$this->Auth->loggedIn()) {
			return;
		}
		if ($model = $this->__getUserModel()) {
			$IPs       = array_values(array_unique(array_merge(
				(array) $this->controller->request->clientIp(false), $this->Auth->user('ip')
			)));
			$date      = AppModel::date();
			$model->id = $this->Auth->user('id');
			$model->save(array(
				$model->alias => array(
					'ip'        => $IPs,
					'online'    => $date,
					'lastlogin' => $date
				)
			));
			if ($this->Auth->user('lastlogin') === AppModel::date(false)) {
				CakeSession::write(AuthComponent::$sessionKey.'.lastlogin', $date);
			}
		}
	}

	/**
	 * beforeLogout Callback
	 *
	 * Updates user data before logout.
	 *
	 * @return void
	 */
	public function beforeLogout()
	{
		if (!$this->Auth->loggedIn()) {
			return;
		}
		if ($model = $this->__getUserModel()) {
			$model->id = $this->Auth->user('id');
			$model->save(array(
				$model->alias => array(
					'online' => AppModel::date(false)
				)
			));
		}
	}

	/**
	 * Gets user model.
	 *
	 * @return mixed User model on success, false on failure.
	 */
	private function __getUserModel()
	{
		foreach ($this->Auth->authenticate as $auth) {
			if (isset($auth['userModel'])) {
				return ClassRegistry::init($auth['userModel']);
			}
		}

		return false;
	}
}
