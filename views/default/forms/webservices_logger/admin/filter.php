<?php

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'datetime-local',
			'#label' => elgg_echo('webservices_logger:forms:admin:filter:created_after'),
			'name' => 'created_after',
			'value' => elgg_extract('created_after', $vars),
		],
		[
			'#type' => 'datetime-local',
			'#label' => elgg_echo('webservices_logger:forms:admin:filter:created_before'),
			'name' => 'created_before',
			'value' => elgg_extract('created_before', $vars),
		],
		[
			'#type' => 'objectpicker',
			'#label' => elgg_echo('webservices_logger:forms:admin:filter:api_key'),
			'name' => 'api_key',
			'value' => elgg_extract('api_key', $vars),
			'subtype' => \ElggApiKey::SUBTYPE,
			'limit' => 1,
		],
		[
			'#type' => 'submit',
			'#label' => '&nbsp;',
			'#class' => ['elgg-field-stretch', 'elgg-justify-right'],
			'icon' => 'search',
			'text' => elgg_echo('search'),
		],
	],
]);
