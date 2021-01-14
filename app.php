<?php

require __DIR__ . '/vendor/autoload.php';

$commands = require __DIR__ . '/example/conf_commands.php';

$application = new App\ConsoleApp($commands);
$exitCode = $application->run();
exit($exitCode);
