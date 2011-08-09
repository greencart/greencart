<?php

/*
 * This file is part of the GreenCart package.
 *
 * Copyright (c) 2011 Sebastian Ionescu
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Email configuration class.
 *
 * @see SwiftMailerComponent
 * @author Sebastian Ionescu <sebastian.c.ionescu@gmail.com>
 */
class EmailConfig
{
	/**
	 * Default email options.
	 *
	 * @var array
	 */
	public static $defaults = array(
		'from'          => array('root@localhost' => 'Root User'),
		'sender'        => array(),
		'to'            => array(),
		'cc'            => array(),
		'bcc'           => array(),
		'subject'       => null,
		'body'          => null,
		'date'          => null,
		'returnPath'    => null,
		'replyTo'       => array(),
		'readReceiptTo' => array(),
		'contentType'   => 'text/plain',
		'charset'       => 'utf-8',
		'priority'      => 3,
		'headers'       => array(),
		'template'      => null,
		'layout'        => 'default',
		'viewVars'      => array(),
		'transport'     => 'smtp',
		'sendmail'      => '/usr/sbin/sendmail -bs',
		'smtp'           => array(
			'host'       => 'localhost',
			'port'       => 25,
			'auth'       => false,
			'username'   => '',
			'password'   => '',
			'encryption' => '',
			'timeout'    => 15
		)
	);
}
