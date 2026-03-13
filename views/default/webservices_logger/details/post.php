<?php
/**
 * Show POST details about an API request
 *
 * @uses $vars['entity'] the log entry
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

$post = $entity->post_params;
if (empty($post)) {
	echo elgg_echo('webservices_logger:details:post:none');
	return;
}

$post = json_decode($post, true);

$rows = [];
foreach ($post as $key => $value) {
	$row = [
		elgg_format_element('td', ['class' => 'elgg-nowrap'], $key),
		elgg_format_element('td', [], $value),
	];
	
	$rows[] = elgg_format_element('tr', [], implode(PHP_EOL, $row));
}

echo elgg_format_element('table', ['class' => 'elgg-table'], implode(PHP_EOL, $rows));
