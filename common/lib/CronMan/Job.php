<?php

	namespace CronMan;
	abstract class Job {
		private $wasExecuted = false;

		protected $command = null;
		protected $returnCode = null;
		protected $returnEcho = null;

		abstract public function setExecCommand($string) ;
		abstract public function getExecCommand();

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
		 * @return int The runtime output of the job or FALSE if the job has not been executed yet
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
