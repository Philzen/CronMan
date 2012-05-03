<?php
$this->pageTitle=Yii::app()->name . ' - Installation ';
$this->breadcrumbs=array(
	'Setup', 'Select Database'
);
?>
<h2>Setup</h2>
<h3><? if (!Yii::app()->session['config']) echo 'Step 2 - '; ?>Select Database Flavour</h3>

<?php
	echo $form;

if (!Yii::app()->session['config']):	?>
<p>In the next step you will configure the database connection details (if any required)</p>
<?php endif; ?>

