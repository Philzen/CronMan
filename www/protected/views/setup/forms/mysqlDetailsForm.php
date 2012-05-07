<?php

	return array(
		'title' => 'Please enter the MySQL database connection details below',
		'showErrorSummary' => true,
		'elements' => array(
			'hostname' => array(
				'type' => 'text',
				'maxlength' => 128,
				'label' => 'Host',
			),
			'port' => array(
				'type' => 'text',
				'maxlength' => 5,
				'label' => 'Port',
				'default' => empty($_POST) ? 3306 : null,
			),
			'dbname' => array(
				'type' => 'text',
				'maxlength' => 64,
				'label' => 'Database',
				'value' => empty($_POST) ? 'cronman' : null,
				'hint' => 'The DB Logon User needs to be the onwer of the Database'
			),
			'username' => array(
				'type' => 'text',
				'maxlength' => 32,
				'label' => 'Username',
			),
			'password' => array(
				'type' => 'password',
				'label' => 'Password',
			),
		),
		'buttons'=>array(
			'submit'=>array(
				'type'=>'submit',
				'label'=>'Test Connection',
			),
		),
	);