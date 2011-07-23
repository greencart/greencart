<?php

/*
 * This file is part of the TwigTemplates plugin package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * CakePHP extension for Twig Template Engine
 *
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class Twig_Extension_Cake extends Twig_Extension
{
	/**
	 * Returns a list of functions to add to the existing list.
	 *
	 * @return array An array of functions
	 */
	public function getFunctions()
	{
		return array(
			'__'    => new Twig_Function_Function('__'),
			'__n'   => new Twig_Function_Function('__n'),
			'__d'   => new Twig_Function_Function('__d'),
			'__dn'  => new Twig_Function_Function('__dn'),
			'__dc'  => new Twig_Function_Function('__dc'),
			'__dcn' => new Twig_Function_Function('__dcn'),
			'__c'   => new Twig_Function_Function('__c'),
		);
	}

	/**
	 * Returns a list of global variables to add to the existing list.
	 *
	 * @return array An array of global variables
	 */
	public function getGlobals()
	{
		return array();
	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'cake';
	}
}
