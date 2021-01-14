<?php


namespace App;


class ConsoleArgs
{
	/**
	 * @var string|null
	 */
	public ?string $command;

	/**
	 * @var array
	 */
	public array $arguments;

	/**
	 * @var array
	 */
	public array $options;

	/**
	 * ConsoleArgs constructor.
	 * @param array $args
	 */
	public function __construct(array $args)
	{
		$this->command = $this->parseCommand($args);
		$this->arguments = $this->parseArguments($args);
		$this->options = $this->parseOptions($args);
	}

	/**
	 * Parse command from array $args
	 * @param array $args
	 * @return mixed|null
	 */
	protected function parseCommand(array $args)
	{
		$firstArg = isset($args[1])? $args[1] : null;
		if (preg_match('/^[\w]+/', $firstArg, $matches)) {
			return $firstArg;
		}
		else {
			return null;
		}
	}

	/**
	 * Parse arguments from array $args
	 * @param array $args
	 * @return array
	 */
	protected function parseArguments(array $args)
	{
		unset($args[0], $args[1]);
		$arguments = [];

		foreach ($args as $arg) {
			if (preg_match('/^\{[\w,]+\}/', $arg, $matches)) {
				$items = preg_split("/[\s,]+/", substr($arg, 1, -1));

				$arguments = array_merge($arguments, $items);
			}
		}
		return $arguments;
	}

	/**
	 * Parse options and values from array $args
	 * @param array $args
	 * @return array
	 */
	protected function parseOptions(array $args)
	{
		$options = [];
		foreach ($args as $arg) {
			if (preg_match('/\[(\w+)=(.*)\]/', $arg, $matches)) {
				if (preg_match('/^\{[\w,]+\}$/', $matches[2])) {
					$items = preg_split("/[\s,]+/", substr($matches[2], 1, -1));
					$options[$matches[1]] = $items;
				}
				else {
					$options[$matches[1]] = $matches[2];
				}
			}
		}
		return $options;
	}
}
