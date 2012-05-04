<?php

	class SetupController extends Controller
	{
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

		/**
		 * This is the default 'index' action that is invoked
		 * when an action is not explicitly requested by users.
		 */
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

			$model = new DbDetailsForm();

			if (!isset($_POST['DbDetailsForm']) && isset(Yii::app()->session['config']['db']))
				$model->attributes = Yii::app()->session['config']['db'];
			$form = new CForm('application.views.setup.'.$config['db']['type'].'DetailsForm', $model);

			// Restore previous entries, if present

			if ($form->submitted('submit') && $form->validate())
			{
				// Merge and store to session
				$config['db'] = array_merge($config['db'], $model->getAttributes());
				Yii::app()->session['config'] = $config;

				$dbSuccess = $this->testDbConnection($config['db']);
				if (true === $dbSuccess) {
					// even in case of success we're still showing the details, therefore we're disabling user editing
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
			$this->render( 'createDb',
					array ('configured' => $this->cmInstalled())
			);

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

		protected function disableForm(CForm $form)
		{
			foreach ($form->elements as $element) {
				$element->attributes['readonly'] = 'readonly';
			}
		}

		protected function testDbConnection($dbConfig)
		{
			try {
				$db = new CDbConnection($dbConfig['type'].':dbname='.$dbConfig['dbname'].';host='.$dbConfig['hostname'], $dbConfig['username'], $dbConfig['password']);
				$db->setActive(true);
			} catch (CDbException $exc) {
				return $exc->getMessage();
			}
			return true;

		}

	}