<?php

	namespace CronMan\Job;
	use \CronMan\Job;
	class Local extends Job {

		const TYPE = Job\Type::LOCAL;

		/**
		 * Set the command to be executed
		 * @param string $command
		 * @return \CronMan\Job\Local
		 */
		public function setExecCommand($command) {
			$this->command = $command;
			return $this;
		}

		/**
		 * @return string
		 */
		public function getExecCommand(){
			return $this->command;
		}

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
