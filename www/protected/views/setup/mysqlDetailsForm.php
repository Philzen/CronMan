<?php

	return array(
		'title' => 'Please enter the MySQL database connection details below',
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
				'value' => 3306,
			),
			'dbname' => array(
				'type' => 'text',
				'maxlength' => 64,
				'label' => 'Database',
				'value' => 'cronman',
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