<?php

	namespace CronMan\Command;

use \CronMan\Command;

	class Local extends Command
	{
		const TYPE = Command\Type::LOCAL;

		/**
		 * Executes The Command
		 * @return \CronMan\Job\Local
		 */
		public function execute()
		{
			exec($this->command, $this->returnEcho, $this->returnCode);
			$this->wasExecuted = true;
			return $this;
		}

	}

