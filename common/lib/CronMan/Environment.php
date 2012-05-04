<?php
	namespace CronMan;
	class Environment {

		protected static $crontabCache = null;

		/**
		 * Check for PHP Version greater than 5.3.7
		 * @return boolean
		 */
		public static function hasModernPhp()
		{
			$phpversion = explode('-', phpversion());
			$phpversion = explode('.', $phpversion[0] );
			return
				($phpversion[0] == 5 && $phpversion [1] == 3 && $phpversion[2] > 7)
				|| ($phpversion[0] == 5 && $phpversion [1] > 3)
				|| ($phpversion[0] > 5);
		}

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
			$lastLine = exec('crontab -l 2>&1', $testOutput, $testResultCode);
			if ( ($testResultCode == 0 || $testResultCode == 1 ) && false === strpos(strtolower( implode("\n", $testOutput)), 'permission denied') ) {
				self::$crontabCache = implode("\n", $testOutput);
				return true;
			}

			return false;
		}

		/**
		 * Check if "crontab -e" can be executed on current machine
		 * @param $writableDir string Any directory writable to the server process - required only if Yii-Library is not available
		 * @todo Test thoroughly respectively find a better way to detect permission to edit crontab
		 */
		public static function canEditCrontab($writableDir)
		{
			if (!self::canListCrontab())
				return false;

			if (file_put_contents($writableDir.'/tmp.cron.cm', self::$crontabCache)) {
				$testOutput = null;
				$testResultCode = null;
				exec("crontab $writableDir/tmp.cron.cm 2>&1", $testOutput, $testResultCode);
				if ($testResultCode == 0 && false === strpos(strtolower( implode("\n", $testOutput)), 'permission denied'))
					return true;
			}
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

		/**
		 * Check if the Environment has the curl module installed
		 * (curl_init() needs to exists, to be precise)
		 * @return boolean
		 */
		public static function hasCurlModule()
		{
			return function_exists('curl_init');
		}
	}