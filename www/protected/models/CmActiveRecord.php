<?php

/**
 */
class CmActiveRecord extends CActiveRecord
{
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function getDbConnection()
	{
		if (self::$db === null)
		{
			$dbConfig = CmConfig::get('db');
			self::$db = new CDbConnection(
					CronMan\DbCreator::getDSN($dbConfig['type'], $dbConfig['hostname'], $dbConfig['port'], $dbConfig['dbname']),
					$dbConfig['username'], $dbConfig['password']
			);
		}

		return self::$db;
	}
}