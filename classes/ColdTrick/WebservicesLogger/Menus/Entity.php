<?php

namespace ColdTrick\WebservicesLogger\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add entries to the entity menu
 */
class Entity {
	
	/**
	 * Add a link to inspect the logs of an api key
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity:object:api_key'
	 *
	 * @return MenuItems|null
	 */
	public static function inspectApiLog(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggApiKey) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'webservices_logger_inspect',
			'icon' => 'search',
			'text' => elgg_echo('webservices_logger:menu:entity:api_key:inspect'),
			'href' => elgg_generate_url('admin', [
				'segments' => 'configure_utilities/ws_logs',
				'api_key' => $entity->guid,
			]),
		]);
		
		return $result;
	}
}
