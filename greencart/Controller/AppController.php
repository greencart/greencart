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
	public $uses = array(
		'Configuration'
	);

	/**
	 * A list of components this controller uses.
	 *
	 * @var array
	 */
	public $components = array(
		'Session', 'Cookie', 'Security', 'Auth', 'RequestHandler', 'Acl', 'Users',
		'DebugKit.Toolbar'
	);

	/**
	 * A list of helpers this controller uses.
	 *
	 * @var array
	 */
	public $helpers = array(
		'Session', 'Html', 'Form', 'Js', 'Config', 'I18n', 'Page', 'Customer'
	);

	/**
	 * The name of the View class this controller sends output to.
	 *
	 * @var string
	 */
	public $viewClass = 'TwigTemplates.Twig';

	/**
	 * The name of the View theme this controller uses.
	 *
	 * @var string
	 */
	public $theme = 'GreenCart';

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
		// Initialize controller-level configuration settings

		Config::init($this);

		$this->request->addDetector('admin', array(
			'callback' => array(__CLASS__, 'adminRequestDetector')
		));

		// Auth component settings

		if ($this->request->isAdmin()) {
			$properties = array(
				'loginAction'    => array('controller' => 'administrators', 'action' => 'login'),
				'loginRedirect'  => array('controller' => 'administrators', 'action' => 'dashboard'),
				'logoutRedirect' => array('controller' => 'administrators', 'action' => 'login'),
				'authError'      => __d('admin', 'error_auth_forbidden'),
				'authenticate'   => array(
					'Form' => array(
						'userModel' => 'Administrator'
					)
				)
			);
			AuthComponent::$sessionKey = 'Auth.Administrator';
		} else {
			$properties = array(
				'loginAction'    => Url::i18n(array('controller' => 'customers', 'action' => 'login')),
				'loginRedirect'  => '/',
				'logoutRedirect' => '/',
				'authError'      => __('customers_login_error_forbidden'),
				'authenticate'   => array(
					'Form' => array(
						'userModel' => 'Customer',
						'fields'    => array('username' => 'email', 'password' => 'password')
					)
				)
			);
			AuthComponent::$sessionKey = 'Auth.Customer';
		}
		foreach ($properties as $property => $value) {
			$this->Auth->{$property} = $value;
		}

		// Security component settings

		$this->Security->requireAuth();
	}

	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @return void
	 */
	public function beforeRender()
	{
		if ($this->request->isAdmin()) {
			$this->theme = 'GreenCartAdmin';
		}
	}

	/**
	 * Called after the controller action is run and rendered.
	 *
	 * @return void
	 */
	public function afterFilter() {}

	/**
	 * Redirects to given URL.
	 *
	 * @param mixed $url A string or array-based URL pointing to another location within the app
	 * @param integer $status Optional HTTP status code (eg: 404)
	 * @param bool $exit If true, exit() will be called after the redirect
	 * @return mixed
	 */
	public function redirect($url, $status = null, $exit = true)
	{
		// short notation

		$url = Url::shortNotation($url);

		// multilanguage support

		$url = Url::i18n($url);

		return parent::redirect($url, $status, $exit);
	}

	/**
	 * Used to set a session variable that can be used to output messages in the view.
	 *
	 * @param string $message Message to be flashed.
	 * @param array $params Parameters to be sent to layout as view variables.
	 * @return void
	 */
	public function setFlash($message, $params = array())
	{
		if (is_string($params)) {
			$params = array('key' => $params);
		}
		$key     = (isset($params['key']) ? $params['key'] : 'flash');
		$element = (isset($params['element']) ? $params['element'] : 'default');
		unset($params['key'], $params['element']);

		$this->Session->setFlash($message, $element, $params, $key);
	}

	/**
	 * Makes available the specified helper in view.
	 *
	 * @param string $helper The name of helper.
	 * @param array $settings A list of settings.
	 * @return void
	 */
	public function loadHelper($helper, $settings = array())
	{
		if (!in_array($helper, $this->helpers) && !array_key_exists($helper, $this->helpers)) {
			if ($settings) {
				$this->helpers[$helper] = $settings;
			} else {
				$this->helpers[] = $helper;
			}
		}
	}

	/**
	 * Clears request data.
	 *
	 * @return void
	 */
	public function clearRequestData()
	{
		$this->request->data = array();
	}

	/**
	 * Request detector callback to determine whether the request
	 * was made via an admin route or not.
	 *
	 * $this->request->isAdmin();
	 *
	 * @return bool
	 */
	public static function adminRequestDetector($request)
	{
		return !empty($request->params['admin']);
	}
}
