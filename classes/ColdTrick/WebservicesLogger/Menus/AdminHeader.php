<?php

namespace ColdTrick\WebservicesLogger\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin header menu
 */
class AdminHeader {
	
	/**
	 * Register menu items to the admin header menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return MenuItems|null
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (!elgg_is_admin_logged_in()) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'webservices_logs',
			'text' => elgg_echo('webservices_logger:menu:admin_header:logs'),
			'href' => elgg_generate_url('admin', [
				'segments' => 'configure_utilities/ws_logs',
			]),
			'parent_name' => 'webservices',
		]);
		
		return $result;
	}
}
