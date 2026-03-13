<?php

namespace ColdTrick\WebservicesLogger\Plugins;

use ColdTrick\WebservicesLogger\Di\RestLogger;

/**
 * Changes for the webservices plugin
 */
class WebServices {
	
	/**
	 * Listen to the start of a webservice request
	 *
	 * @param \Elgg\Event $event 'rest', 'init'
	 *
	 * @return void
	 */
	public static function restInit(\Elgg\Event $event): void {
		RestLogger::instance()->init();
	}
}
