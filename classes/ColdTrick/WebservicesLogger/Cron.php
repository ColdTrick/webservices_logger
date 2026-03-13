<?php

namespace ColdTrick\WebservicesLogger;

use Elgg\Values;

/**
 * Handle CRON events
 */
class Cron {
	
	/**
	 * Cleanup the api logs
	 *
	 * @param \Elgg\Event $event 'cron', 'daily'
	 *
	 * @return void
	 */
	public static function cleanupLogs(\Elgg\Event $event): void {
		$retention = (int) elgg_get_plugin_setting('retention', 'webservice_logger');
		if ($retention < 1) {
			return;
		}
		
		elgg_call(ELGG_IGNORE_ACCESS, function() use ($retention) {
			/** @var \ElggBatch $entities */
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => \WebserviceLogEntry::SUBTYPE,
				'created_before' => Values::normalizeTimestamp("-{$retention} days"),
				'limit' => false,
				'batch' => true,
				'batch_inc_offset' => false,
			]);
			
			/** @var \WebserviceLogEntry $entity */
			foreach ($entities as $entity) {
				if (!$entity->delete()) {
					$entities->reportFailure();
				}
			}
		});
	}
}
