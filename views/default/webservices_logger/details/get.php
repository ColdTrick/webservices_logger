<?php
/**
 * Show GET details about an API request
 *
 * @uses $vars['entity'] the log entry
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

$get = $entity->get_params;
if (empty($get)) {
	echo elgg_echo('webservices_logger:details:get:none');
	return;
}

$get = json_decode($get, true);

$rows = [];
foreach ($get as $key => $value) {
	$row = [
		elgg_format_element('td', ['class' => 'elgg-nowrap'], $key),
		elgg_format_element('td', [], $value),
	];
	
	$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, $row));
}

echo elgg_format_element('table', ['class' => 'elgg-table'], implode(PHP_EOL, $rows));
