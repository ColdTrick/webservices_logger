<?php
/**
 * Show the success state of a webservice request
 */

$entity = elgg_extract('item', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

if ($entity->success) {
	echo elgg_format_element('span', ['class' => ['elgg-state', 'elgg-state-success']], elgg_echo('webservices_logger:log_entry:success'));
} else {
	echo elgg_format_element('span', ['class' => ['elgg-state', 'elgg-state-error']], elgg_echo('webservices_logger:log_entry:error'));
}
