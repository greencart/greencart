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
 * SwiftMailerComponent
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class SwiftMailerComponent extends Component
{
	/**
	 * SwiftMailer options.
	 *
	 * @var object
	 */
	protected $_options;

	/**
	 * A reference to the instantiating controller object.
	 *
	 * @var object
	 */
	protected $_controller;

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
		$this->_controller = $controller;
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
		config('email');

		$options = EmailConfig::$defaults;
		$from    = array(
			'name'  => Config::get('SHOP_NAME'),
			'email' => Config::get('SHOP_EMAIL_NOREPLY')
		);
		if ($from['email']) {
			if ($from['name']) {
				$options['from'] = array($from['email'] => $from['name']);
			} else {
				$options['from'] = array($from['email']);
			}
		}
		if (Config::get('MAILER_SMTP_HOST')) {
			foreach (array_keys($options['smtp']) as $key) {
				$options['smtp'][$key] = Config::get(
					'MAILER_SMTP_'.strtoupper(Inflector::underscore($key))
				);
			}
		}
		$params              = $controller->request->params;
		$options['template'] = Inflector::underscore($params['controller'].ucfirst($params['action']));
		$options['charset']  = I18n::getInstance()->l10n->charset;
		$this->_options      = $options;
	}

	/**
	 * Sends an email.
	 *
	 * @param array $options Email options
	 * @return int
	 */
	public function send($options = array())
	{
		if (!defined('SWIFT_REQUIRED_LOADED')) {
			App::import('Vendor', 'swiftmailer'.DS.'lib'.DS.'swift_required');
		}

		$options += $this->_options;
		$message  = Swift_Message::newInstance();

		$keys = array(
			'from', 'to', 'subject'
		);
		foreach ($keys as $key) {
			$message->{'set'.ucfirst($key)}($options[$key]);
		}

		$keys = array(
			'sender', 'cc', 'bcc', 'date', 'returnPath', 'replyTo', 'readReceiptTo', 'contentType',
			'charset', 'priority'
		);
		foreach ($keys as $key) {
			if ($options[$key]) {
				$message->{'set'.ucfirst($key)}($options[$key]);
			}
		}

		if ($options['body']) {
			$message->setBody($options['body']);
		} else {
			$message->setBody($this->_renderBody($options), 'text/html');
			$message->addPart($this->_renderBody($options, 'text'), 'text/plain');
		}

		foreach ($options['headers'] as $name => $value) {
			$message->getHeaders()->addTextHeader($name, $value);
		}

		switch ($options['transport']) {
			case 'smtp':
				$smtp      = $options['smtp'];
				$transport = Swift_SmtpTransport::newInstance($smtp['host'], $smtp['port']);
				if ($smtp['auth']) {
					$transport->setUsername($smtp['username']);
					$transport->setPassword($smtp['password']);
				}
				foreach (array('encryption', 'timeout') as $key) {
					if ($smtp[$key]) {
						$transport->{'set'.ucfirst($key)}($smtp[$key]);
					}
				}
				break;
			case 'sendmail':
				$transport = Swift_SendmailTransport::newInstance($options['sendmail']);
				break;
			default:
				$transport = Swift_MailTransport::newInstance();
		}

		return Swift_Mailer::newInstance($transport)->send($message);
	}

	/**
	 * Renders the body content using the specified layout and template.
	 *
	 * @param string $content Content to render
	 * @return string Body content
	 */
	protected function _renderBody($options, $type = 'html')
	{
		$viewClass = $this->_controller->viewClass;

		if ($viewClass !== 'View') {
			list($plugin, $viewClass) = pluginSplit($viewClass, true);
			$viewClass .= 'View';
			App::uses($viewClass, $plugin . 'View');
		}

		$View = new $viewClass($this->_controller);

		list($templatePlugin, $template) = pluginSplit($options['template'], true);
		list($layoutPlugin, $layout)     = pluginSplit($options['layout'], true);

		if (!empty($templatePlugin)) {
			$View->plugin = rtrim($templatePlugin, '.');
		} elseif (!empty($layoutPlugin)) {
			$View->plugin = rtrim($layoutPlugin, '.');
		}

		$View->viewVars = $options['viewVars'];
		$View->viewPath = $View->layoutPath = 'Emails'.DS.$type.DS.I18n::getInstance()->l10n->locale;

		return $View->render($template, $layout);
	}
}
