<?php
$this->pageTitle=Yii::app()->name . ' - Configure Database ';
$this->breadcrumbs=array(
	'Setup', 'Database Connection'
);
?>
<h2>Setup</h2>
<h3><? if (!$configured) echo 'Step 3 - '; ?>Configure Database Connection Details</h3>

<div class="form">
	<? echo $form;
	if ($dbSuccess === true): ?>
	<div class="flash-success">
		<p>Nice! Connection succeded.</p>
		<? if(!$configured): ?>
		<p>Click OK to go to the next step 4 (Creating the CronMan Database).</p>
		<? endif;	?>
	</div>
	<?
	elseif(is_string($dbSuccess)):	?>
	<div class="flash-error">
		<p>Hate to say, but these details don't seem to work. Connect failed with following message</p>
		<span>
		<?=$dbSuccess ?></span>
		<br /><br />
		<p>Please review the message and your login details above and try again.</p>
	</div>

		<?
	endif;


?>



</div><!-- form -->

