<?php


namespace App;


class ConsolePrint
{
	/**
	 * Default shift for included values on print
	 */
	const DEFAULT_SHIFT = 4;

	/**
	 * Print command arguments and options
	 * @param string $command
	 * @param array $arguments
	 * @param array $options
	 */
	static function printCommandDescription(
		string $command,
		array $arguments,
		array $options
	)
	{
		self::printLine();

		self::printLine("Called command: " . $command);

		self::printLine();

		if (count($arguments) > 0) {
			self::printLine('Arguments:');
			self::printArray($arguments);
		} else {
			self::printLine('No arguments');
		}

		self::printLine();

		if (count($options) > 0) {
			self::printLine('Options:');
			self::printArray($options);
		} else {
			self::printLine('No options');
		}

		self::printLine();
		return;
	}

	/**
	 * Print text with $shift spaces before and break line after
	 * @param string $text
	 * @param int $shift
	 */
	static function printLine(
		string $text = '',
		int $shift = 0
	)
	{
		if ($text == '') {
			echo "\n";
			return;
		}
		echo str_repeat(' ', $shift) . $text . "\n";
		return;
	}

	/**
	 * Print array keys and values with $shift spaces and $prefix before each value
	 * @param array $array
	 * @param int $shift
	 * @param string $prefix
	 */
	static function printArray(
		array $array,
		int $shift = 0,
		string $prefix = ' -  '
	)
	{
		foreach ($array as $key => $val) {
			$valueShift = 0;
			if (!is_int($key)) {
				self::printLine(
					str_repeat(' ', $shift)
					. $prefix
					. $key
				);
				$valueShift = self::DEFAULT_SHIFT;
			}
			if (is_array($val)) {
				self::printArray(
					$val,
					$shift + $valueShift
				);
			}
			else {
				self::printLine(
					str_repeat(' ', $shift + $valueShift)
					. $prefix
					. $val
				);
			}
		}
		return;
	}

	/**
	 * Print array keys and values
	 * @param array $array
	 * @param int $shift
	 * @param string $prefix
	 * @param string $separator
	 */
	static function printArrayWithDescriptions(
		array $array,
		int $shift = 0,
		string $prefix = ' -  ',
		string $separator = "\t"
	)
	{
		foreach ($array as $key => $val) {
			self::printLine(
				str_repeat(' ', $shift)
				. $prefix
				. $key
				. $separator
				. $val
			);
		}
		return;
	}
}
