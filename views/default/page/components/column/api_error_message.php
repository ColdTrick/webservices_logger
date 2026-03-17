<?php
/**
 * Show the API error message
 */

$entity = elgg_extract('item', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

echo elgg_get_excerpt((string) $entity->error_message, 100);
