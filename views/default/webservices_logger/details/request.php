<?php
/**
 * Show request details about an API request
 *
 * @uses $vars['entity'] the log entry
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

$rows = [];

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:time_created')),
	elgg_format_element('td', [], elgg_view('output/date', [
		'value' => $entity->time_created,
		'format' => DateTimeInterface::RFC2822,
	])),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('table_columns:fromProperty:api_method')),
	elgg_format_element('td', [], $entity->api_method),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:request_method')),
	elgg_format_element('td', [], $entity->request_method),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:view_type')),
	elgg_format_element('td', [], $entity->output_viewtype),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:user_agent')),
	elgg_format_element('td', [], $entity->user_agent),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:response_time')),
	elgg_format_element('td', [], elgg_view('output/date', [
		'value' => $entity->response_time,
		'format' => DateTimeInterface::RFC2822,
	])),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('table_columns:fromView:api_success')),
	elgg_format_element('td', [], $entity->success ? elgg_echo('webservices_logger:log_entry:success') : elgg_echo('webservices_logger:log_entry:error')),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:result_code')),
	elgg_format_element('td', [], $entity->result_code),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('table_columns:fromView:api_error_message')),
	elgg_format_element('td', [], $entity->error_message ?? '&nbsp;'),
]));

$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, [
	elgg_format_element('td', ['class' => 'elgg-nowrap'], elgg_echo('webservices_logger:details:request:api_key')),
	elgg_format_element('td', [], $entity->getApiKey()?->getDisplayName() ?: '&nbsp;'),
]));

echo elgg_format_element('table', ['class' => 'elgg-table'], implode(PHP_EOL, $rows));
