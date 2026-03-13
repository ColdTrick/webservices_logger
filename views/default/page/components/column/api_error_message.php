<?php
/**
 * Show the API error message
 */

$entity = elgg_extract('item', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

echo $entity->error_message;
