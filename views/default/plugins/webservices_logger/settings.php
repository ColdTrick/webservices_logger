<?php

$plugin = elgg_extract('entity', $vars);
if (!$plugin instanceof \ElggPlugin) {
	return;
}

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('webservices_logger:settings:retention'),
	'#help' => elgg_echo('webservices_logger:settings:retention:help'),
	'name' => 'params[retention]',
	'value' => $plugin->retention,
	'min' => 0,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('webservices_logger:settings:log_type'),
	'#help' => elgg_echo('webservices_logger:settings:log_type:help'),
	'name' => 'params[log_type]',
	'value' => $plugin->log_type,
	'options_values' => [
		'all' => elgg_echo('webservices_logger:settings:log_type:all'),
		'error' => elgg_echo('webservices_logger:settings:log_type:error'),
		'none' => elgg_echo('webservices_logger:settings:log_type:none'),
	],
]);
