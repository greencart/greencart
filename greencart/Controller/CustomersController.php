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
 * CustomersController
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class CustomersController extends AppController
{
	/**
	 * A list of components this controller uses.
	 *
	 * @var array
	 */
	public $components = array('SwiftMailer');

	/**
	 * Called before the controller action.
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();

		// Auth component settings

		$this->Auth->allow('register', 'recover');
	}

	/**
	 * CustomersController::login() Action
	 *
	 * @return void
	 */
	public function login()
	{
		if ($this->Auth->loggedIn()) {
			$this->redirect($this->Auth->redirect());
		}
		if ($this->request->isPost()) {
			if ($this->Auth->login()) {
				if (!$this->Auth->user('enabled')) {
					$this->Auth->logout();
					$this->setFlash(__('customers_login_error_disabled'), 'auth');
				} else if ($this->Auth->user('blocked')) {
					$this->Auth->logout();
					$this->setFlash(__('customers_login_error_blocked'), 'auth');
				} else {
					$this->Users->afterLogin();

					//TODO: [ActivityLog] Successfull login

					$this->redirect($this->Auth->redirect());
				}
			} else {

				//TODO: [ActivityLog] Login attempt with bad credentials

				$this->setFlash(__('customers_login_error_bad_credentials'), 'auth');
			}
			$this->clearRequestData();
		}
	}

	/**
	 * CustomersController::logout() Action
	 *
	 * @return void
	 */
	public function logout()
	{
		if ($this->Auth->loggedIn()) {
			$this->Users->beforeLogout();

			//TODO: [ActivityLog] Successfull logout

		}
		$this->redirect($this->Auth->logout());
	}

	/**
	 * CustomersController::recover() Action
	 *
	 * @return void
	 */
	public function recover()
	{
	}

	/**
	 * CustomersController::register() Action
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->Auth->loggedIn()) {
			$this->redirect($this->Auth->redirect());
		}
		if ($this->request->data) {
			$data = $this->request->data = AppModel::clean($this->request->data);
/*
			$data['Customer'] = array_merge($data['Customer'], array(
				'captcha' => $this->ImageAuth->check($data['Customer']['captcha'])
			));
*/
			if ($this->Customer->set($data) && $this->Customer->validates()) {
				$data['Customer'] = array_merge($data['Customer'], array(
					'ip'       => array($this->request->clientIp(false)),
					'tmp'      => array(),
					'password' => AuthComponent::password($data['Customer']['password']),
					'enabled'  => true
				));
				$this->Customer->create();
				if ($this->Customer->save($data, false)) {
/*
					$this->Email->send(array(
						'to'       => sprintf('%s <%s>', $this->data['Customer']['name'],
							$this->data['Customer']['email']
						),
						'subject'  => 'Bun venit pe ' . Configure::read('Conf.SITE_NAME'),
						'template' => 'registration',
						'sendAs'   => 'text',
						'viewVars' => array(
							'customer' => $this->data,
							'confirm'  => $this->Customer->id . '-' . $confirm
						)
					));
*/
					$this->redirect($this->Auth->loginAction);
				}
			}
			unset($this->request->data['Customer']['captcha']);
		}
	}
}
