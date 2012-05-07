<?php

	return array(
		'title' => 'Please select a database you would like to use',
		'elements' => array(
			'dbType' => array(
				'type' => 'dropdownlist',
				'items' => array('pgsql' =>'PostgreSQL', 'mysql'=>'MySQL', 'sqlite' => 'SQLite', 'php' => 'Local (Custom CronMan DB)'),
				'prompt' => 'Please select a database system'
			)
		),
		'buttons'=>array(
			'ok'=>array(
				'type'=>'submit',
				'label'=>'OK',
			),
		),
	);