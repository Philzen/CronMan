<?php

class SelectDbForm extends CFormModel
{
	public $dbType;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('dbType', 'required'),
			array('dbType', 'in', 'range' => array('pgsql', 'mysql', 'sqlite'), 'message' => 'Invalid Database Type'),
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