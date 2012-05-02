<?php

	$testCommand = 'ps aux | grep apache';
	$libPath = '../../common/lib/CronMan';
	$host = 'example.com';
	$port = 22;
	$username = 'guest';

	require "$libPath/Command.php";
	require "$libPath/Command/Type.php";
	require "$libPath/Command/Local.php";
	require "$libPath/Command/SSH.php";
	require "$libPath/Host/Connection/SSH.php";

	use Cronman\Command;

	$formatTestOutputFunction = function($returnCode, $outputArray, $message = "Test Results: ") {
		return "$message (Return Code: $returnCode)\n"
		.implode("\n", $outputArray). "\n";
	};

	$localTestJob = new Command\Local();
	$localTestJob->set($testCommand)
			->execute();

	echo $formatTestOutputFunction($localTestJob->getReturnCode(), $localTestJob->getReturnEcho(), "LOKALER TEST: \n");

	$sshTestJob = new Command\SSH();
	$sshRemoteHost = new CronMan\Host\Connection\SSH();
	$sshRemoteHost->setHostname($host)
				->setPort($port)
				->setUsername($username);

	$sshTestJob->setHost($sshRemoteHost);

	$sshTestJob->set($testCommand)
			->execute();

	echo $formatTestOutputFunction($sshTestJob->getReturnCode(), $sshTestJob->getReturnEcho(), "SSH TEST: \n");
