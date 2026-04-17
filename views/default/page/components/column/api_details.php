<?php
/**
 * Show a link to more log details
 */

$entity = elgg_extract('item', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

echo elgg_view('output/url', [
	'icon' => 'search',
	'text' => elgg_echo('table_columns:fromView:api_details'),
	'href' => elgg_generate_url('ajax', [
		'type' => 'view',
		'segments' => 'webservices_logger/details',
		'guid' => $entity->guid,
	]),
	'class' => 'elgg-lightbox',
]);
