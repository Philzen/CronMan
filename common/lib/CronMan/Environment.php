<?php
	namespace CronMan;
	class Environment {

		/**
		 * Check if PDO Module for SQLite is available
		 * @return boolean
		 */
		public static function hasSQLiteModules()
		{
			return extension_loaded('pdo_sqlite');
		}

		/**
		 * Check if PDO Module for MySql is available
		 * @return boolean
		 */
		public static function hasMySqlModules()
		{
			return extension_loaded('pdo_mysql');
		}

		/**
		 * Check if PDO Module for PostgreSql is available
		 * @return boolean
		 */
		public static function hasPgSqlModules()
		{
			return extension_loaded('pdo_pgsql');
		}

		/**
		 * Check if "crontab -l" can be executed on current machine
		 * @return boolean
		 */
		public static function canListCrontab()
		{
			$testOutput = null;
			$testResultCode = null;
			exec('crontab -l', $testOutput, $testResultCode);
			if ($testResultCode == 0 && false === strpos(strtolower( implode("\n", $testOutput)), 'denied') )
				return true;

			return false;
		}

		/**
		 * Check if "crontab -e" can be executed on current machine
		 * @return boolean
		 * @todo Test thoroughly respectively find a better way to detect permission to edit crontab
		 */
		public static function canEditCrontab()
		{
			$testOutput = null;
			$testResultCode = null;
			exec('crontab -e', $testOutput, $testResultCode);
			if ($testResultCode == 1 && false === strpos(strtolower( implode("\n", $testOutput)), 'permission denied') && false === strpos(strtolower( implode("\n", $testOutput)), 'keine berechtigung'))
				return true;

			return false;
		}

		/**
		 * Checks if "ssh -V" can be called without errors on this machine
		 * @return boolean
		 * @todo Test thoroughly respectively find a better way to test ssh capabilities
		 */
		public static function canUseSsh()
		{
			$testOutput = array();
			$testResultCode = null;
			exec('ssh -V;', $testOutput, $testResultCode);
			if ($testResultCode == 0 && ( (count($testOutput) == 0) ||
					(false === strpos(strtolower( implode("\n", $testOutput)), 'permission denied') && false === strpos(strtolower( implode("\n", $testOutput)), 'keine berechtigung')
					) )
				)
				return true;

			return false;
		}
	}