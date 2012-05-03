<?php

class DbDetailsForm extends CFormModel
{
	public $hostname;
	public $username;
	public $password;
	public $database;
	public $port;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('hostname, username, password, port', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'dbType'=>'Database Type',
		);
	}
}