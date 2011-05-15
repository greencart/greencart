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
 * Email configuration class. You can specify multiple configurations for production,
 * development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		mail 		- Send using PHP mail function
 *		smtp		- Send using SMTP
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email.  Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 * @author CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 */
class EmailConfig
{
	public $default = array(
		'transport' => 'mail',
		'from'      => 'you@localhost'
	);

	public $smtp = array(
		'transport' => 'smtp',
		'from'      => array('My Site', 'site@localhost'),
		'host'      => 'localhost',
		'port'      => 25,
		'timeout'   => 30,
		'username'  => 'user',
		'password'  => 'secret',
		'client'    => null
	);

	public $fast = array(
		'from'        => 'you@localhost',
		'sender'      => null,
		'to'          => null,
		'cc'          => null,
		'bcc'         => null,
		'replyTo'     => null,
		'readReceipt' => null,
		'returnPath'  => null,
		'messageId'   => true,
		'subject'     => null,
		'message'     => null,
		'headers'     => null,
		'viewRender'  => null,
		'template'    => false,
		'layout'      => false,
		'viewVars'    => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport'   => 'smtp',
		'host'        => 'localhost',
		'port'        => 25,
		'timeout'     => 30,
		'username'    => 'user',
		'password'    => 'secret',
		'client'      => null
	);
}
