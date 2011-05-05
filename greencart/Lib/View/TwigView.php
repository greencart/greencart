<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('ThemeView', 'View');
App::import('Lib', 'Twig/Autoloader');

/**
 * TwigView offers support for Twig Template Egine
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class TwigView extends ThemeView
{
	/**
	 * File extension for view templates.
	 *
	 * @var string
	 */
	public $ext = '.twig';

	/**
	 * Twig Environment Instance
	 *
	 * @var Twig_Environment
	 */
	public $Twig;

	/**
	 * TwigView Constructor
	 *
	 * @param Controller $controller A controller object.
	 */
	public function __construct($controller)
	{
		parent::__construct($controller);

		Twig_Autoloader::register();

		$loader     = new Twig_Loader_Filesystem(current(App::path('View')));
		$this->Twig = new Twig_Environment($loader, Configure::read('Twig'));

		$this->Twig->addExtension(new Twig_Extension_GreenCart());
	}

	/**
	 * Renders and returns output for given view filename with its array of data.
	 *
	 * @param string $___viewFn Filename of the view.
	 * @param array $___dataForView Data to include in rendered view.
	 * @return string Rendered output.
	 */
	protected function _render($___viewFn, $___dataForView = array())
	{
		if (empty($___dataForView)) {
			$___dataForView = $this->viewVars;
		}

		ob_start();

		if (substr($___viewFn, -3) === 'ctp') {
			extract($___dataForView, EXTR_SKIP);
			include($___viewFn);
		} else {
			foreach ($this->Helpers->enabled() as $helper) {
				$this->{Inflector::underscore($helper)} = $this->Helpers->{$helper};
			}

			$___dataForView['view'] = $this;
			$___viewFn = str_replace(current(App::path('View')), '', $___viewFn);

			try {
				echo $this->Twig->loadTemplate($___viewFn)->render($___dataForView);
			} catch (RuntimeException $e) {
				debug($e);
			} catch (Twig_Error_Syntax $e) {
				debug($e);
			} catch (Twig_Error_Runtime $e) {
				debug($e);
			} catch (Twig_Error $e) {
				debug($e);
			}
		}

		return ob_get_clean();
	}
}
