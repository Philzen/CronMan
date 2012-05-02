<?php

	namespace CronMan\Host\Connection;

	class SSH
	{
		/**
		 * @var SSH::DEFAULT_PORT Standard port for SSH Communication
		 */
		const DEFAULT_PORT = 22;

		protected $hostname = null;
		protected $port = self::DEFAULT_PORT;
		protected $username = null;
		protected $password = null;

		public function getHostname()
		{
			return $this->hostname;
		}

		public function setHostname($hostname)
		{
			$this->hostname = $hostname;
			return $this;
		}

		public function getPort()
		{
			return $this->port;
		}

		public function setPort($port)
		{
			$this->port = (int)$port;
			return $this;
		}

		public function getUsername()
		{
			return $this->username;
		}

		public function setUsername($username)
		{
			$this->username = $username;
			return $this;
		}

		public function getPassword()
		{
			return $this->password;
		}

		public function setPassword($password)
		{
			$this->password = $password;
			return $this;
		}

		public function isValid()
		{
			if (is_string($this->hostname) && null !== $this->port && null !== $this->username)
				return true;

			return false;
		}
	}