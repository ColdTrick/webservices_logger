<?php

return [
	'plugin' => [
		'version' => '0.1',
		'dependencies' => [
			'web_services' => [],
		],
	],
	'settings' => [
		'retention' => 30,
		'log_type' => 'all',
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'webservice_log_entry',
			'class' => \WebserviceLogEntry::class,
		],
	],
	'events' => [
		'cron' => [
			'daily' => [
				'\ColdTrick\WebservicesLogger\Cron::cleanupLogs' => [],
			],
		],
		'register' => [
			'menu:admin_header' => [
				'\ColdTrick\WebservicesLogger\Menus\AdminHeader::register' => [],
			],
			'menu:entity:object:api_key' => [
				'\ColdTrick\WebservicesLogger\Menus\Entity::inspectApiLog' => [],
			],
		],
		'rest' => [
			'init' => [
				'\ColdTrick\WebservicesLogger\Plugins\WebServices::restInit' => [],
			],
		],
	],
	'view_options' => [
		'webservices_logger/details' => ['ajax' => true],
	],
];
