<?php
	namespace CronMan;
	class Environment {

		public static function hasSQLiteModules()
		{
			return extension_loaded('pdo_sqlite');
		}

		public static function hasMySqlModules()
		{
			return extension_loaded('pdo_mysql');
		}

		public static function hasPgSqlModules()
		{
			return extension_loaded('pdo_pgsql');
		}

	}