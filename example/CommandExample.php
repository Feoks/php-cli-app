<?php

namespace Example;

use App\ConsoleArgs;
use App\ConsolePrint;

class CommandExample
{
	/**
	 * This is example of console command
	 * @param ConsoleArgs $params
	 */
	public function index(ConsoleArgs $params)
	{
		ConsolePrint::printCommandDescription(
			$params->command,
			$params->arguments,
			$params->options
		);
	}

	/**
	 * This is example of console command
	 * @param ConsoleArgs $params
	 */
	public function second(ConsoleArgs $params)
	{
		echo "Second Command";
	}
}
