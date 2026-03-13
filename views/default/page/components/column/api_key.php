<?php
/**
 * Show the API key that was used
 */

$entity = elgg_extract('item', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

$key = $entity->getApiKey();
if (!$key instanceof \ElggApiKey) {
	echo '&nbsp;';
	return;
}

echo elgg_get_excerpt($key->getDisplayName(), 20);
