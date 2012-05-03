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
			if (!Yii::app()->params['config'])
				$this->forward('setup/prerequisites');
			// renders the view file 'protected/views/setup/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			$this->render('index');
		}

		public function actionConfigureDb()
		{
			$config =Yii::app()->params['config'];
			if ($config['dbType'] < 2) {
				$model = new DbDetailsForm();
				if ($config['dbType'] == 0)
					$form = new CForm('application.views.setup.pgDetailsForm', $model);
				else
					$form = new CForm('application.views.setup.myDetailsForm', $model);
			}
			$this->render('configureDb', array ('form' => $form));
		}

		public function actionSelectDb()
		{
			$model = new SelectDbForm();
			$form = new CForm('application.views.setup.selectDbForm', $model);
			if ($form->submitted('ok') && $form->validate()) {
				// TODO write to config file
				Yii::app()->params['config'] = array('dbType' => (int)$model->dbType);
				$this->forward('setup/configureDb');
			}
			$this->render('select-db', array ('form' => $form));
		}

		public function actionPrerequisites()
		{
			// renders the view file 'protected/views/site/index.php'
			// using the default layout 'protected/views/layouts/main.php'
			$this->render('prerequisites');
		}

	}