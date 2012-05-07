<?php

/**
 * @author Phil. Austermann
 * @package CronMan
 */
class CmConfig
{
	protected static $cmConfig = null;
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public static function get($key = null)
	{
		if (self::$cmConfig === null)
		{
			if (!file_exists( Yii::app()->params['configPath'] . '/' .Yii::app()->params['configFile'] ))
				throw new CDbException('Dear Developer: No CronMan config file existing yet - make sure whatever tried to do takes place after the setup process has been completed.');

			self::$cmConfig = include Yii::app()->params['configPath'] . '/' .Yii::app()->params['configFile'];
		}

		if ($key !== null && isset(self::$cmConfig[$key]))
			return self::$cmConfig[$key];

		return self::$cmConfig;
	}
}