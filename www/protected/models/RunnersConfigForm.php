<?php

class RunnersConfigForm extends CFormModel
{
	public $type;
	public $concurrencyNumber;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('type,concurrencyNumber', 'required'),
			array('type', 'in', 'range' => array('internal', 'external'), 'message' => 'Invalid RunnerType'),
			array('concurrencyNumber', 'type', 'type' => 'numeric'),
		);
	}
}