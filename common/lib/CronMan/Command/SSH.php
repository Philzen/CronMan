<?php

	namespace CronMan\Command;

use \CronMan\Command;
use \CronMan\Host\Connection;

	class SSH extends Command
	{
		const TYPE = Command\Type::SSH;

		/**
		 * @var $hostConnection CronMan\Host\Connection\SSH
		 */
		protected $hostConnection = null;

		public function getHost()
		{
			return $this->hostConnection;
		}

		public function setHost(Connection\SSH $host)
		{
			$this->hostConnection = $host;
		}

		/**
		 * Executes The Command
		 * @return \CronMan\Command\Local
		 */
		public function execute()
		{
			if ($this->hostConnection !== null && $this->hostConnection->isValid())
			{
				$exec = $this->getSshCommand() . ' "' . $this->command . '"';
				exec($exec, $this->returnEcho, $this->returnCode);

				$this->wasExecuted = true;
			}

			return $this;
		}

		protected function getSshCommand()
		{
			$sshCommand = 'ssh ';

			if ($this->hostConnection->getPort() !== Connection\SSH::DEFAULT_PORT)
				$sshCommand .= '-p' . $this->hostConnection->getPort() . ' ';

			$sshCommand .= $this->hostConnection->getUsername() . '@' . $this->hostConnection->getHostname();
			return $sshCommand;
		}

	}

