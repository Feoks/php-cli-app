<?php
return [
	'command_name' => [
		'class_name' => \Example\CommandExample::class,
		'method' => 'index',
		'desc' => 'This is description for command',
		'arguments' => [
			'verbose',
			'overwrite',
			'unlimited',
			'log',
		],
		'options' => [
			'log_file',
			'methods',
			'paginate',
		],
	],
	'second_command' => [
		'class_name' => \Example\CommandExample::class,
		'method' => 'second',
		'desc' => 'Description for Second Command',
		'arguments' => [
			'verbose',
			'log',
		],
		'options' => [
			'log_file',
		],
	],
];
