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
 * Administrators Controller
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class AdministratorsController extends AppController
{
	/**
	 * AdministratorsController::dashboard() Action
	 *
	 * @return void
	 */
	public function admin_dashboard() {}

	/**
	 * AdministratorsController::login() Action
	 *
	 * @return void
	 */
	public function admin_login()
	{
		if ($this->Auth->loggedIn()) {
			$this->redirect($this->Auth->redirect());
		}
		if ($this->request->isPost()) {
			if ($this->Auth->login()) {
				if ($this->Auth->user('enabled')) {
					$this->Users->afterLogin();

					//LOG: Successfull login

					$this->redirect($this->Auth->redirect());
				} else {
					$this->Auth->logout();

					//LOG: Login attempt with disabled account

					$this->setFlash(__d('admin', 'error_auth_login_disabled'), 'auth');
				}
			} else {

				//LOG: Login attempt with bad credentials

				$this->setFlash(__d('admin', 'error_auth_login'), 'auth');
			}
			$this->clearRequestData();
		}
	}

	/**
	 * AdministratorsController::logout() Action
	 *
	 * @return void
	 */
	public function admin_logout()
	{
		if ($this->Auth->loggedIn()) {
			$this->Users->beforeLogout();

			//LOG: Successfull logout

		}
		$this->redirect($this->Auth->logout());
	}
}
