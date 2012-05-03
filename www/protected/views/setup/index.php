<?php
$this->pageTitle=Yii::app()->name . ' - Setup';
$this->breadcrumbs=array(
	'Setup',
);

/* @var $this PostController */
/* @var $model Post */
?>

<h2>Setup</h2>

<? if (!Yii::app()->session['config']): ?>
<p>
	You don't have configured CronMan yet. <a href="<?= $this->createUrl('setup/prerequisites') ?>">Click here</a> to go to the Prerequisites Screen and check what the current server environment will enable us to do out-of-the-box!
</p>
<? else:
	/** TODO implement */
	echo "Render Menu";
endif;
?>


