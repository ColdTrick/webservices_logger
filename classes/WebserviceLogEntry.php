<?php

/**
 * Webservice log entry
 *
 * @property string $api_method      Used API method
 * @property string $request_method  Request method (POST|GET)
 * @property int    $result_code     API result code
 * @property bool   $success         Success (or error when false)
 * @property string $error_message   In case of error the error message
 * @property int    $response_time   UNIX timestamp when the response was sent
 * @property array  $get_params      GET params
 * @property array  $post_params     POST params
 * @property string $output_viewtype Requested output view type (JSON|XML|etc )
 * @property string $user_agent      User-Agent used for the request
 * @property int    $api_key         GUID of the used \ELggApiKey
 */
class WebserviceLogEntry extends \ElggObject {
	
	public const SUBTYPE = 'webservice_log_entry';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
		$this->attributes['access_id'] = ACCESS_PRIVATE;
	}
	
	/**
	 * Get the API key used for this request
	 *
	 * @return ElggApiKey|null
	 */
	public function getApiKey(): ?\ElggApiKey {
		if (empty($this->api_key)) {
			return null;
		}
		
		$entity = get_entity($this->api_key);
		
		return $entity instanceof \ElggApiKey ? $entity : null;
	}
}
