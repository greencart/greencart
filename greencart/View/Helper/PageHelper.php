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
 * Administrators Controller
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class PageHelper extends AppHelper
{
	/**
	 * Other helpers used by this helper.
	 *
	 * @var array
	 */
	public $helpers = array('Html');

	/**
	 * Sets or gets page title.
	 *
	 * @param string $title
	 * @return mixed
	 */
	public function title($title = null, $options = array())
	{
		if (is_null($title)) {
			$title    = $this->_View->viewVars['title_for_layout'];
			$options += array(
				'shopTitle' => Config::get('SHOP_TITLE')
			);
			if ($options['shopTitle']) {
				$title .= Config::get('SHOP_TITLE_SEPARATOR').$options['shopTitle'];
			}
			return $title;
		}
		if (is_array($title)) {
			$title = implode(Config::get('SHOP_TITLE_SEPARATOR'), $title);
		}
		$this->_View->set('title_for_layout', $title);
	}

	/**
	 * Sets or gets page description.
	 *
	 * @param string $description
	 * @return mixed
	 */
	public function description($description = null)
	{
		if (is_null($description)) {
			if (isset($this->_View->viewVars['description_for_layout'])) {
				return $this->_View->viewVars['description_for_layout'];
			}
			return Config::get('SHOP_DESCRIPTION');
		}
		$this->_View->set('description_for_layout', $description);
	}

	/**
	 * Sets or gets page keywords.
	 *
	 * @param mixed $keywords
	 * @param array $options
	 * @return mixed
	 */
	public function keywords($keywords = null, $options = array())
	{
		if (is_null($keywords)) {
			if (isset($this->_View->viewVars['keywords_for_layout'])) {
				$keywords = $this->_View->viewVars['keywords_for_layout'];
			}
			if (is_string($keywords)) {
				$keywords = explode(',', $keywords);
			} else {
				$keywords = (array) $keywords;
			}
			$options += array('count' => Config::get('SEO_KEYWORDS_MAX'), 'minLength' => 2);
			$keywords = array_merge($keywords, explode(',', Config::get('SEO_KEYWORDS')));
			$keywords = array_unique(array_map('strtolower', array_map('trim', $keywords)));
			foreach ($keywords as $key => $value) {
				if (strlen($value) < $options['minLength']) {
					unset($keywords[$key]);
				}
			}
			return implode(',', array_slice($keywords, 0, $options['count']));
		}
		$this->_View->set('keywords_for_layout', $keywords);
	}

	/**
	 * Returns scripts for the current page.
	 *
	 * @return string
	 */
	public function scripts()
	{
		return $this->_View->viewVars['scripts_for_layout'];
	}

	/**
	 * Returns content for the current page.
	 *
	 * @return string
	 */
	public function content()
	{
		return $this->_View->viewVars['content_for_layout'];
	}

	/**
	 * Returns a bookmark link.
	 *
	 * @param string $title
	 * @param array $options
	 * @return string
	 */
	public function bookmark($title, $options = array())
	{
		$options += array(
			'class' => 'siteBookmark',
			'title' => $this->layoutTitle()
		);
		return $this->Html->link($title, $this->Html->url(null, true), $options);
	}
}
