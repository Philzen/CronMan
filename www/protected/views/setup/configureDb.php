<?php
$this->pageTitle=Yii::app()->name . ' - Installation ';
$this->breadcrumbs=array(
	'Setup', 'Database Connection'
);
?>
<h2>Setup</h2>
<h3><? if (!Yii::app()->session['config']) echo 'Step 3 - '; ?>Configure Database Connection Details</h3>
<?php
	echo $form;