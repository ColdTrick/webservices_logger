<?php

use ColdTrick\WebservicesLogger\Di\RestLogger;

return [
	RestLogger::name() => \Di\autowire(RestLogger::class),
	
	// map classes to alias to allow autowiring
	RestLogger::class => \Di\get(RestLogger::name()),
];
