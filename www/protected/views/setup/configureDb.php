<?php
$this->pageTitle=Yii::app()->name . ' - Configure Database ';
$this->breadcrumbs=array(
	'Setup', 'Database Connection'
);
?>
<h2>Setup</h2>
<h3><? if (!$configured) echo 'Step 3 - '; ?>Configure Database Connection Details</h3>

<div class="form">
	<?
	if ($dbSuccess === true): ?>
	<div class="flash-success">
		<p>Nice! Connection succeded.</p>
		<? if(!$configured): ?>
		<p>Click OK to go to the next step 4 (Creating the CronMan Database).</p>
		<? endif;	?>
	</div>
	<?
	elseif(is_string($dbSuccess)):	?>
	<div class="errorSummary">
		<p>Hate to say, but these details don't seem to work. Connect failed with following message</p>
		<ul><li>
		<?=$dbSuccess ?></li></ul>
		<p>Please review the message and your login details above and try again.</p>
	</div>

		<?
	endif;

echo $form;
?>



</div><!-- form -->

