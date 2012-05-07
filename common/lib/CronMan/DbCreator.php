<?php
	namespace CronMan;

	/**
	 * A helper class to create the CronMan Database
	 * @uses DbDetailsForm
	 * @uses CDbConnection
	 */
	class DbCreator
	{
		const PERMISSION_USER_TABLE = 'user_id';
		const PERMISSION_DB_OWNER = 'db_owner';
		const PERMISSION_CREATE_TABLE = 'create_table';
		const PERMISSION_DROP_TABLE = 'drop_table';

		/**
		 * SQL in different dialects to check for:
		 * 1. user table access (user_id),
		 * 2. database ownership (db_owner),
		 * 3. create a test table (create_table),
		 * 4. drop the test table (drop_table),
		 * @param array
		 */
		protected $checkSql = array(
			'pgsql' => array(
				self::PERMISSION_USER_TABLE		=> 'SELECT usesysid FROM pg_user WHERE usename = current_user',
				self::PERMISSION_DB_OWNER		=> 'SELECT datdba FROM pg_database where datname = current_database()',
				self::PERMISSION_CREATE_TABLE	=> 'CREATE TABLE test (col1 VARCHAR NOT NULL)',
				self::PERMISSION_DROP_TABLE		=> 'DROP TABLE test'
			),
			'mysql' => null,
			'sqlite' => null
		);

		/** @var boolean Has the database already been created */
		protected $dbExists = null;

		/** @var string version of database */
		protected $dbVersion = null;

		/** @var CDbConnection */
		protected $db = null;

		/**
		 * @throws Exception
		 * @param array $dbConfig An array containing the keys 'hostname', 'port', 'username', 'password' and 'dbname'
		 */
		public function __construct(\DbConnectionDetails $dbConfig)
		{

			if ($dbConfig->hasErrors())
				throw new Exception('The DbConnectionDetails model given to this class had Erros, please validate() and correct any errors before submitting it to this constructor.');

			$this->dbConfig = $dbConfig;
		}

		/**
		 * Check if the Cronman Database Tables have already been created
		 *
		 * @return boolean
		 */
		public function checkCronmanDbExists()
		{
			if (null === $this->dbExists)
			{
				$testSql = "SELECT count(table_name) FROM information_schema.tables WHERE table_schema = 'public' AND table_name in ('config', 'job_run', 'job')";
				try {
					$countTables = $this->getDbConn()->createCommand($testSql)->queryScalar();
					$this->dbExists = $countTables == 3;
				} catch (CDbException $exc) {
					$this->dbExists = false;
				}
			}

			return $this->dbExists;
		}

		/**
		 * Execute the Database creation scripts
		 * @return boolean|array Returns true, or an array containing error/warning messages
		 */
		protected function createDb()
		{
			$errors = array();
			$dbType = $this->dbConfig->dbType;
			$sqls = file_get_contents(Yii::app()->basePath.'/data/schema.'.$dbType.'.sql');
			$sqls = explode(';', $sqls);
			foreach ($sqls as $sql) {
				if (strlen(trim($sql)) === 0)
					continue;

				$db = $this->getDbConn()->createCommand( $sql );
				try {
					$db->execute();
				} catch (CDbException $exc) {
					$errors[] = $exc->getMessage();
				}
			}

			if (count($errors) > 0)
				return $errors;

			return true;
		}

		/**
		 * Checks for necessary Database Permissions to create the CronMan database
		 *
		 * @return array An array containing the keys indexed by the PERMISSIONS_ constants in this class. The values
		 * are either false (for no errors) or contain an array with error messages encountered during the check for
		 * that particular PERMISSION_
		 * @throws Exception In case some database type is tried to be used that has not been tested / implemented yet
		 */
		public function checkDbPermissions()
		{
			$dbType = $this->dbConfig->dbType;
			if ($dbType != 'pgsql')
				throw new \Exception ('Sorry folks - Database support for '.ucfirst ($dbType).' Database is yet to be implemented.');

			$permissionErrors = array();
			$db = $this->getDbConn();
			foreach ($this->checkSql[$dbType] as $permission => $command)
			{
				try {
					$db->createCommand( $command )->queryScalar();
					$permissionErrors[$permission] = false;
				} catch (\Exception $exc) {
					$permissionErrors[$permission] = $exc->getMessage();
				}
			}

			return $permissionErrors;
		}

		/**
		 *
		 * @param array $dbConfig
		 * @return boolean|string Returns True if the Connection succeeded, otherwise returns the Database Error
		 * message that was thrown during the connection attempt
		 */
		public function testDbConnection()
		{
			try {
				$db = $this->getDbConn();
				$db->setActive(true);
			} catch (\CDbException $exc) {
				return $exc->getMessage();
			}
			return true;
		}

		/**
		 *
		 * @param array $dbConfig
		 * @return CDbConnection
		 */
		protected function getDbConn()
		{
			$dbConfig = $this->dbConfig;

			if (!isset($this->db))
				$this->db = new \CDbConnection(
						"{$dbConfig->dbType}:dbname={$dbConfig->dbname};host={$dbConfig->hostname};port={$dbConfig->port}",
						$dbConfig->username, $dbConfig->password );

			return $this->db;
		}
	}