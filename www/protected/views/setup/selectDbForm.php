<?php

	return array(
		'title' => 'Please select a database you would like to use',
		'elements' => array(
			'dbType' => array(
				'type' => 'dropdownlist',
				'items' => array(0=>'PostgreSQL', 1=>'MySQL', 2=> 'SQLite', 3=> 'Local (Custom CronMan DB)'),
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