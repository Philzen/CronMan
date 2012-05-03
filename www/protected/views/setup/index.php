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
		'ssh' => CronMan\Environment::canUseSsh(),
		'curl' => CronMan\Environment::hasCurlModule(),
		'php' => CronMan\Environment::hasModernPhp(),
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
		<tr class="subheader">
			<td>Distributed Databases</td>
			<td colspan="2"><div>You will need one of these if you want scalability over multiple servers.</div></td>
		</tr>
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
		<tr class="subheader">
			<td >Local Database</td>
			<td colspan="2"><div>Will allow you to run standalone without the need of a database service, respectively server.</div></td>
		</tr>
		<tr>
			<td>SQLite "Database" PDO Driver</td>
			<td><?= $format($environment['sqlite']) ?></td>
			<td></td>
		</tr>
		<tr class="subheader">
			<td>Your User Rights</td>
			<td colspan="2"><div>How much command line Kung-Fu is permitted on this machine?</div></td>
		</tr>
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
		<tr>
			<td>CUrl</td>
			<td><?= $format($environment['curl']) ?></td>
			<td>CronMan <?= $canCannot($environment['ssh']) ?> make proper CUrl HTTP calls from this machine.</td>
		</tr>
		<tr class="subheader">
			<td>Other</td>
			<td colspan="2"><div>Other rather notable stuff about the environment</div></td>
		</tr>
		<tr>
			<td>PHP Version (>= 5.3.8 recommended)</td>
			<td><?= $format($environment['php']) ?></td>
			<td>You have Version <?= phpversion() ?> installed, which <?= $canCannot($environment['php']) ?> be relied on to be modern and stable to support CronMan's functionalities.</td>
		</tr>
	</tbody>
</table>
