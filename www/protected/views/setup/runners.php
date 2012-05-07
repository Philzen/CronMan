<?php
$this->pageTitle=Yii::app()->name . ' - Setup';
$this->breadcrumbs=array(
	'Setup',
);

/* @var $this Controller */
?>

<h2>Configure Runners Trigger</h2>

<p>
	Cronman needs some kind of trigger to call up a certain script (called "Runner") every minute.
</p>
<div class="form">
<?= $form; ?>
</div>
