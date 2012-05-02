<?php

	namespace CronMan;

	abstract class Command
	{
		protected $wasExecuted = false;
		protected $command = null;
		protected $returnCode = null;
		protected $returnEcho = null;

		/**
		 * Set the command to be executed
		 * @param string $command
		 * @return \CronMan\Command\Local
		 */
		public function set($command)
		{
			$this->command = $command;
			return $this;
		}

		/**
		 * Get the command to be executed
		 * @return string
		 */
		public function get()
		{
			return $this->command;
		}

		abstract public function execute();

		/**
		 * After having called execute, you may check the result code here (0 generally means everything was OK)
		 * @return int the return code of the job or FALSE if the job has not been executed yet
		 */
		public function getReturnCode()
		{
			if ($this->wasExecuted)
				return $this->returnCode;

			return false;
		}

		/**
		 * After having called execute, you may check the result output here
		 * @return array The runtime output of the job in an array containing one line of output per element,
		 * or FALSE if the job has not been executed yet. s
		 */
		public function getReturnEcho()
		{
			if ($this->wasExecuted)
				return $this->returnEcho;

			return false;
		}

		/**
		 * @return int A value which you can match against Job\Type
		 */
		public function getJobtype()
		{
			return self::TYPE;
		}

	}

