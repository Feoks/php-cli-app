<?php


namespace App;

class ConsoleApp
{
	/**
	 * Commands available in App
	 * @var array
	 */
	protected array $availableCommands;

	/**
	 * Parameters from the command line
	 * @var ConsoleArgs
	 */
	protected ConsoleArgs $params;

	/**
	 * ConsoleApp constructor.
	 * @param array $commands
	 */
	public function __construct(array $commands)
	{
		$this->availableCommands = $commands;
	}

	/**
	 * Running console application
	 * @return int
	 */
	public function run()
	{
		$this->params = new ConsoleArgs($_SERVER['argv']);

		if (!$this->params->command) {
			$this->defaultHelp();
			return 0;
		}

		if (!array_key_exists($this->params->command, $this->availableCommands)) {
			fwrite(STDERR, "Command not found");
			return 1;
		}

		if (in_array('help', $this->params->arguments)) {
			$this->commandHelp(
				$this->params->command,
				$this->availableCommands[$this->params->command]
			);
			return 0;
		}

		return $this->runCommand($this->params);
	}

	/**
	 * @param ConsoleArgs $params
	 * @return mixed
	 */
	public function runCommand(ConsoleArgs $params)
	{
		$commandName = $params->command;

		try {
			$className = $this->availableCommands[$commandName]['class_name'];
			$method = $this->availableCommands[$commandName]['method'];

			return (new $className())->$method($this->params);
		}
		catch (\Exception $e) {
			fwrite(STDERR, $e->getMessage());
			return 1;
		}
	}

	/**
	 * Print default help
	 */
	public function defaultHelp()
	{
		ConsolePrint::printArray([
			'',
			'usage: php app.php command_name {arg} [name1=value] [name2={value1,value2,value3}]',
			'',
			'Available commands:',
		], 0, '');

		$commandsDesc = [];
		foreach ($this->availableCommands as $key => $val) {
			$commandsDesc[$key] = $val['desc'];
		}

		ConsolePrint::printArrayWithDescriptions($commandsDesc);

		ConsolePrint::printArray([
			'',
			'use: php app.php command_name {help}',
			'for show available arguments and options for command "command_name"',
			'',
		], 0, '');
	}

	/**
	 * Print help for command
	 * @param string $commandName
	 * @param array $commandDefinition
	 */
	public function commandHelp(string $commandName, array $commandDefinition)
	{
		ConsolePrint::printCommandDescription(
			$commandName . "\n" . $commandDefinition['desc'],
			$commandDefinition['arguments'],
			$commandDefinition['options'],
		);
	}
}
