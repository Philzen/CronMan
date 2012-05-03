<?php
/* @var $this PostController */
/* @var $model Post */
	$this->pageTitle=Yii::app()->name;

//	die('Hallo :'.CronMan\Command\SSH::TYPE);
	//Yii::import('cronman.*', true);

	$environment = array(
		'mysql' => CronMan\Environment::hasMySqlModules(),
		'pgsql' => CronMan\Environment::hasPgSqlModules(),
		'sqlite' => CronMan\Environment::hasSQLiteModules(),
		'list_cron' => CronMan\Environment::canListCrontab(),
		'edit_cron' => CronMan\Environment::canEditCrontab(),
		'ssh' => CronMan\Environment::canUseSsh()
	);

	$format = function ($checkValue) {
		if ($checkValue)
			return '<div class="success">OK</div>';
		else
			return '<div class="warning">n.A.</div>';
	};

	$canCannot = function ($checkValue) {
		if ($checkValue)
			return 'can';
		else
			return 'cannot';
	};

?>

<h2>Setup CronMan</h2>

<p>Environment Check:</p>
<table>
	<thead>
		<tr>
			<th>Requirement</th>
			<th>Result</th>
			<th>Info</th>
		</tr>
	</thead>
	<tbody>
		<tr><td class="subheader" colspan="3">Distributed Databases<div>Preferable if you want scalability over multiple servers.</div></td></tr>
		<tr>
			<td>MySQL Database PDO Driver</td>
			<td><?= $format($environment['mysql']) ?></td>
			<td></td>
		</tr>
		<tr>
			<td>PostgreSql Database PDO Driver</td>
			<td><?= $format($environment['pgsql']) ?></td>
			<td></td>
		</tr>
		<tr><td class="subheader" colspan="3">Local Database<div>Will allow you to run standalone without the need of a database service, respectively server.</div></td></tr>
		<tr>
			<td>SQLite "Database" PDO Driver</td>
			<td><?= $format($environment['sqlite']) ?></td>
			<td></td>
		</tr>
		<tr><td class="subheader" colspan="3">Your User Rights<div>Checking how powerful your current user on the server is.</div></td></tr>
		<tr>
			<td>List Crontab</td>
			<td><?= $format($environment['list_cron']) ?></td>
			<td>Your php user <?= $canCannot($environment['list_cron']) ?> list its own crontab.</td>
		</tr>
		<tr>
			<td>Edit Crontab</td>
			<td><?= $format($environment['edit_cron']) ?></td>
			<td>Your php user <?= $canCannot($environment['edit_cron']) ?> edit its own crontab.
				<?= $environment['edit_cron'] ? "This means this CronMan is able to install and manage its job runners by itself, which will be more convenient for you :)" : 'This means you will need to <a href="'.$this->createUrl('setup/help').'">install the CronMan runners manually</a>' ?>
			</td>
		</tr>
		<tr>
			<td>SSH</td>
			<td><?= $format($environment['ssh']) ?></td>
			<td>It looks like you <?= $canCannot($environment['ssh']) ?> establish ssh connections to remote servers.</td>
		</tr>
	</tbody>
</table>
