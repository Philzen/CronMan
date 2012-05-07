<?php

	use CronMan\DbCreator;
	class SetupController extends Controller
	{
		protected $db;
		protected $dbConfig;
		protected $dbExists;

		public function init()
		{
			if (isset(Yii::app()->session['config']))
				$this->dbConfig = Yii::app()->session['config']['db'];
		}

		/**
		 * Declares class-based actions.
		 */
		public function actions()
		{
			return array (
				// page action renders "static" pages stored under 'protected/views/setup/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page' => array (
					'class' => 'CViewAction',
				),
			);
		}

		public function actionIndex()
		{
			// renders the view file 'protected/views/setup/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			$this->render('index', array('configured' => $this->cmInstalled()));
		}

		public function actionPrerequisites()
		{
			// renders the view file 'protected/views/site/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			$this->render('prerequisites', array('configured' => $this->cmInstalled() ));
		}

		public function actionSelectDb()
		{
			$model = new SelectDbForm();
			$form = new CForm('application.views.setup.selectDbForm', $model);

			// Restore setting, if present
			if (isset(Yii::app()->session['config']['db']['type']))
				$model->dbType = Yii::app()->session['config']['db']['type'];

			if ($form->submitted('ok') && $form->validate()) {
				$config = array('installation-finished' => false, 'db' => array('type' => $model->dbType));

				if ($this->cmConfigLoaded())
					$config = array_merge($config, Yii::app()->session['config']);

				Yii::app()->session['config'] = $config;

				$this->redirect($this->createUrl('setup/configureDb'));
			}
			$this->render('select-db', array ('form' => $form, 'configured' => $this->cmInstalled()));
		}

		public function actionConfigureDb()
		{
			$dbSuccess = false;
			$config =Yii::app()->session['config'];

			$model = new DbConnectionDetails();
			if (!isset($_POST['DbDetailsForm']) && isset(Yii::app()->session['config']['db']))
				$model->attributes = Yii::app()->session['config']['db'];
			$model->dbType = $config['db']['type'];
			$form = new CForm('application.views.setup.'.$config['db']['type'].'DetailsForm', $model);

			// Restore previous entries, if present

			if ($form->submitted('submit') && $form->validate())
			{
				// Merge and store to session
				$config['db'] = array_merge($config['db'], $model->getAttributes());
				Yii::app()->session['config'] = $config;

				$cronmanDbHelper = new DbCreator($model);
				$dbSuccess = $cronmanDbHelper->testDbConnection();
				if (true === $dbSuccess) {
					// in case of success we're still showing the details, therefore we're disabling user editing
					$this->disableForm ($form);
					$this->writeConfig();
					$form->action = $this->createUrl('setup/createDb');
				}
			}

			$this->render( 'configureDb',
				array ('form' => $form, 'model' => $model, 'configured' => $this->cmInstalled(), 'dbSuccess' => $dbSuccess)
			);
		}

		public function actionCreateDb()
		{
			$dbConfig = new DbConnectionDetails();
			$dbConfig->attributes = Yii::app()->session['config']['db'];
			$viewParams = array('configured' => $this->cmInstalled(), 'dbUser' => $dbConfig->username, 'dbName' => $dbConfig->dbname);

			$cronmanDbHelper = new DbCreator($dbConfig);

			$dbCreated = false;

			if (isset($_POST['create-now']))
				$dbCreated = $cronmanDbHelper->createDb();
			else
				$viewParams['permissionErrors'] = $cronmanDbHelper->checkDbPermissions();


			$viewParams['dbCreated'] = $dbCreated;
			$viewParams['dbExists'] = $cronmanDbHelper->checkCronmanDbExists();
			if ($viewParams['dbExists'] && (null !== $dbVersion = Config::model()->findByPk( Config::KEY_DB_VERSION )))
				$viewParams['dbVersion'] = $dbVersion->value;
			else
				$viewParams['dbVersion'] = '{NULL}';

			$this->render( 'createDb',$viewParams);
		}

		/**
		 * Only executed on very first installation, will generate the config file for CronMan's database connection, etc...
		 */
		protected function writeConfig()
		{
			$generator = new APhpDb\ConfigFile();
			$generator->setArray(Yii::app()->session['config']);
			return $generator->save( Yii::app()->params['configPath'] . '/' .Yii::app()->params['configFile'] );
		}

		/**
		 * Sets all Form elements to 'readonly'
		 * @param CForm $form
		 */
		protected function disableForm(CForm $form)
		{
			foreach ($form->elements as $element) {
				$element->attributes['readonly'] = 'readonly';
			}
		}

	}