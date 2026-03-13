<?php

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => \WebserviceLogEntry::SUBTYPE,
	'no_results' => true,
	'limit' => 50,
	'list_type' => 'table',
	'columns' => [
		elgg()->table_columns->time_created(),
		elgg()->table_columns->fromProperty('api_method'),
		elgg()->table_columns->fromProperty('request_method'),
		elgg()->table_columns->fromView('api_key'),
		elgg()->table_columns->fromView('api_success'),
		elgg()->table_columns->fromView('api_error_message'),
		elgg()->table_columns->fromView('api_details'),
	],
]);
