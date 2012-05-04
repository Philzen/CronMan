<?php
$this->pageTitle=Yii::app()->name . ' - Select Database';
$this->breadcrumbs=array(
	'Setup', 'Select Database'
);
?>
<h2>Setup</h2>
<h3><? if (!$configured) echo 'Step 2 - '; ?>Select Database Flavour</h3>
<div class="form">
<?php
	echo $form; ?>
</div>

<? if (!$configured):	?>
<p>In the next step you will configure the database connection details (if any required)</p>
<?php endif; ?>

