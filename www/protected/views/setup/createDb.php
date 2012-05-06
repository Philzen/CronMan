<?php
$this->pageTitle=Yii::app()->name . ' - Create CronMan Database';
$this->breadcrumbs=array(
	'Setup', 'Database Connection'
);

$labels = array(
	'user_id' => array(
		'name' => 'Check User Id',
		'ok' => "Login user '$dbUser' can check the user table for its own id",
		'error' => "Either this is the wrong database or the wrong owner, but as matter of fact login User '$dbUser' is not owner of database '$dbName'",
	),
	'db_owner' => array(
		'name' => 'Database Owner',
		'ok' => "Login user '$dbUser' is the owner of database '$dbName'",
		'error' => "It looks like the logon user '$dbUser' is not owner of database '$dbName' - or this user has no permissions to query this piece of information. Please check the errors below and also if you maybe have the right logon user but the wrong database (or vice versa).",
	),
	'create_table' => array(
		'name' => 'Create Test Table',
		'ok' => "Login user '$dbUser' can create tables.",
		'error' => "Database creation failed.",
	),
	'drop_table' => array(
		'name' => 'Remove Test Table',
		'ok' => "Login user '$dbUser' can delete it's own tables.",
		'error' => "Dropping of the test database failed.",
	),
);


$okNotOk = function ($key, $permissionErrors)
{
	if ($permissionErrors[$key] === false)
		return '<span style="flash-success">OK</span>';
	return '<span style="flash-error">-</span>';
};

$renderErrors = function ($key, $permissionErrors, $labels)
{
	if (is_array($permissionErrors[$key]) && count($permissionErrors[$key]) > 0) {
		$returnHtml = '<div class="error-summary">'.$labels[$key]['error'].'<ul>';
		foreach ($permissionErrors[$key] as $error)
			$returnHtml .= "<li>$error</li>";
		$returnHtml .= '</ul></div>';
		return $returnHtml;
	} else
		return $labels[$key]['ok'];
};

?>
<h2>Setup</h2>
<h3><? if (!$configured) echo 'Step 4 - '; ?>Create CronMan Database</h3>

<div class="form">
	<form method="post">
<?		if (count($permissionErrors)):
			$weCanRunTheCreationScript = true;	?>
		<table>
			<caption>Checking your Database Permissions...</caption>
			<thead>
				<tr><th>Test</th><th>Result</th><th></th></tr>
			</thead>
			<tbody>
<?			foreach ($permissionErrors as $key => $errors):
				if (is_array($errors)) $weCanRunTheCreationScript = false;
?>
				<tr>
					<td><?= $labels[ $key ]['name'] ?></td>
					<td><?= $okNotOk($key, $permissionErrors) ?></td>
					<td><?= $renderErrors($key, $permissionErrors, $labels) ?></td>
				</tr>
<?			endforeach;	?>
				<tr>
					<td>CronMan Database Tables existing</td>
					<td><?= $dbExists ? 'OK' : '-'  ?></td>
					<td>CronMan database does <?= $dbExists ? null : 'not' ?> seem to have been initialised (completely) yet.</td>
				</tr>
			</tbody>
		</table>
<?		if ($weCanRunTheCreationScript && !$dbExists):	?>
			<p>Now we're ready to create the database tables for the application</p>
			<input type="submit" name="create-now" value="Create Database Now" />
<?		elseif ($dbExists):	?>
			<p>The CronMan database has already been created before, so there is nothing do here.</p>
<?		else:	?>
			<p>There seem to be some problems with your permissions. Presumably you should log into your database with a administrative privileges and make sure that the user you entered (<?= $dbUser ?>) is the owner of the database (<?= $dbName ?>), and (as a minimum) that the user is able to create tables in that database. </p>
			<p>Or go back and review the connection data</p>
			<input type="button" value="Modify DB Login Data" />
			<input type="submit" name="create-now" value="Try to create database anyway" />
<?		endif;	?>
	<? endif;
		if ($dbCreated === true):	?>
			<div class="flash-success">
				<p>The Cronman Database has successfully been created.</p>
			</div>
<?		elseif (is_array($dbCreated)):
			if ($dbExists):?>
			<div class="flash-notice">
				<p>The Cronman Database was created with errors:</p>
<?			else:	?>
			<div class="errorSummary">
				<p>There were errors trying to create the cronman database.</p>
<?			endif;	?>
				<ul>
<?			foreach ($dbCreated as $creationError):	?>
					<li><?= $creationError ?></li>
<?			endforeach;	?>
				</ul>
			</div>
<?		endif;
	?>

	</form>
</div><!-- form -->

