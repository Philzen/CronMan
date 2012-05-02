<?php

	namespace CronMan\Command;
	class Type {

			/**
			 *@var int A locally executable script
			 */
			const LOCAL = 0;

			/**
			 *@var int A script that's executed via SSH
			 */
			const SSH = 1;

			/**
			 *@var int Something that's triggered via HTTP
			 */
			const HTTP = 2;

	}
