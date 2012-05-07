<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function __construct($id, $module = null)
	{
		parent::__construct($id, $module);

		// TODO Find a better place to do the following
		if (file_exists( Yii::app()->params['configPath'] . '/' .Yii::app()->params['configFile'] ))
		{
			$cronmanConfig = CmConfig::get();
			if (!$this->cmInstalled())
				// as long as Installation process is not completed, the config is carried over in
				Yii::app()->session['config'] = $cronmanConfig;

//			$this->prepareCronmanDatabase($cronmanConfig['db']);
		}


		if ($this->id !== 'setup' && !$this->cmInstalled())
			$this->redirect(Yii::app()->baseUrl . '/setup');
	}

	protected function cmConfigLoaded()
	{
		// Yii::app()->session->clear();
		return isset(Yii::app()->session['config']);
	}

	protected function cmInstalled()
	{
		return isset(Yii::app()->session['config']['installation-finished']) && Yii::app()->session['config']['installation-finished'] !== false;
	}
