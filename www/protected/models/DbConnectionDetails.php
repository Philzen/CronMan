<?php

class DbConnectionDetails extends CFormModel
{
	public $dbType;
	public $hostname;
	public $username;
	public $password;
	public $dbname;
	public $port;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('hostname,port,dbname,username,password', 'required'),
			array('port', 'type', 'type' => 'integer'),
			array('dbType', 'type', 'type' => 'hidden'),
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

		);
	}
}