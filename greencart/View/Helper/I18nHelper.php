<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('AppHelper', 'View/Helper');

/**
 * I18nHelper
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class I18nHelper extends AppHelper
{
	/**
	 * Other helpers used by this helper.
	 *
	 * @var array
	 */
	public $helpers = array('Html');

	/**
	 * Instance of the I18n class.
	 *
	 * @var I18n
	 */
	public $I18n = null;

	/**
	 * Class constructor
	 *
	 * @param View $View The View this helper is being attached to.
	 * @param array $settings Configuration settings for the helper.
	 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->I18n = I18n::getInstance();
	}

	/**
	 * Returns the current language.
	 *
	 * @return string
	 */
	public function lang()
	{
		return $this->I18n->l10n->lang;
	}

	/**
	 * Returns the current locale.
	 *
	 * @return string
	 */
	public function locale()
	{
		return $this->I18n->l10n->locale;
	}

	/**
	 * Returns encoding used for current locale.
	 *
	 * @return string
	 */
	public function charset()
	{
		return $this->I18n->l10n->charset;
	}

	/**
	 * Returns text direction for current locale.
	 *
	 * @return string
	 */
	public function dir()
	{
		return $this->I18n->l10n->direction;
	}

	/**
	 * Returns a list of language selector links.
	 *
	 * @return array
	 */
	public function links()
	{
		$links   = array();
		$I18n    = Configure::read('I18n');
		$pattern = '/^('.implode('|', array_map('preg_quote', $I18n['languages'])).')\/*/i';
		$url     = preg_replace($pattern, '', $this->request->url);

		foreach ($I18n['languages'] as $lang) {
			if ($lang !== $I18n['default']) {
				$link = rtrim('/'.$lang.'/'.$url, '/');
			} else {
				$link = '/'.$url;
			}
			$links[$lang] = Router::url($link, true);
		}

		return $links;
	}
}
