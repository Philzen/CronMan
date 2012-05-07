<?php

	return array(
		'title' => 'Runner setup',
		'showErrorSummary' => true,
		'elements' => array(
			'type' => array(
				'type' => 'dropdownlist',
				'items' => array('internal' => 'Install cronjobs on server', 'external' => 'Ping cronman from external server'),
				'label' => 'Type of setup',
				'hint' => 'Installing a local cronjob is highly recommended.'
			),
			'concurrencyNumber' => array(
				'type' => 'text',
				'maxlength' => 2,
				'label' => 'Concurrency',
				'hint' => 'Determines how many jobs will be processed simultaneously. As a good rule of thumb, start setting this value to the number of CPU Cores available on your server',
			),
		),
		'buttons'=>array(
			'reset'=>array(
				'type'=>'reset',
				'label'=>'Reset Changes',
			),
			'update-runners'=>array(
				'type'=>'submit',
				'label'=>'Save',
			),
		),
	);