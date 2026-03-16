<?php

use Elgg\Values;

elgg_register_menu_item('title', [
	'name' => 'filter',
	'icon' => 'filter',
	'text' => elgg_echo('filter'),
	'href' => false,
	'link_class' => ['elgg-button', 'elgg-button-action', 'elgg-toggle'],
	'data-toggle-selector' => '#webservices-logger-admin-filter-form',
]);

$list_options = [
	'type' => 'object',
	'subtype' => \WebserviceLogEntry::SUBTYPE,
	'no_results' => true,
	'limit' => 50,
	'list_type' => 'table',
	'metadata_name_value_pairs' => [],
	'columns' => [
		elgg()->table_columns->time_created(),
		elgg()->table_columns->fromProperty('api_method'),
		elgg()->table_columns->fromProperty('request_method'),
		elgg()->table_columns->fromView('api_key'),
		elgg()->table_columns->fromView('api_success'),
		elgg()->table_columns->fromView('api_error_message'),
		elgg()->table_columns->fromView('api_details'),
	],
];

$form_class = ['mbl'];
$body_vars = [];
$show = false;
foreach (['created_before', 'created_after', 'api_key'] as $input) {
	$value = get_input($input);
	
	if (!empty($value)) {
		$body_vars[$input] = $value;
		$show = true;
		
		switch ($input) {
			case 'created_after':
			case 'created_before':
				$list_options[$input] = Values::normalizeTimestamp($value);
				break;
			case 'api_key':
				$list_options['metadata_name_value_pairs'][] = [
					'name' => 'api_key',
					'value' => $value,
					'type' => ELGG_VALUE_GUID,
				];
				break;
		}
	}
}

if (!$show) {
	$form_class[] = 'hidden';
}

echo elgg_view_form('webservices_logger/admin/filter', [
	'id' => 'webservices-logger-admin-filter-form',
	'action' => elgg_generate_url('admin', [
		'segments' => 'configure_utilities/ws_logs',
	]),
	'method' => 'GET',
	'prevent_double_submit' => false,
	'disable_security' => true,
	'class' => $form_class,
], $body_vars);

echo elgg_list_entities($list_options);
