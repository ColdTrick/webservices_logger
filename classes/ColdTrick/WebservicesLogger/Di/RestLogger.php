<?php

namespace ColdTrick\WebservicesLogger\Di;

use Elgg\Router\Route;
use Elgg\Traits\Di\ServiceFacade;

/**
 * Log webservice requests
 */
class RestLogger {
	
	use ServiceFacade;
	
	protected ?\WebserviceLogEntry $entity = null;
	
	protected ?string $log_type = null;
	
	/**
	 * Create service
	 *
	 * @param \Elgg\EventsService $events Events service
	 */
	public function __construct(protected \Elgg\EventsService $events) {
		$this->log_type = elgg_get_plugin_setting('log_type', 'webservices_logger');
	}
	
	/**
	 * Cleanup actions
	 */
	public function __destruct() {
		if (!$this->entity instanceof \WebserviceLogEntry) {
			return;
		}
		
		elgg_call(ELGG_IGNORE_ACCESS, function () {
			if (!$this->events->trigger('api_log', 'webservices_logger', $this->entity)) {
				return;
			}
			
			if ($this->log_type === 'none') {
				return;
			} elseif ($this->log_type === 'error' && $this->entity->success) {
				return;
			}
			
			$this->entity->save();
		});
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function name() {
		return 'webservices_logger.logger';
	}
	
	/**
	 * Initialize the tracking of the request and response
	 *
	 * @return void
	 */
	public function init(): void {
		$this->events->registerHandler('view_vars', 'api/output', [$this, 'apiOutput']);
		
		$request = _elgg_services()->request;
		
		$this->entity = new \WebserviceLogEntry();
		$this->entity->time_created = time();
		$this->entity->api_method = get_input('method');
		$this->entity->request_method = $request->getMethod();
		$this->entity->user_agent = $request->headers->get('User-Agent');
		$this->entity->output_viewtype = elgg_get_viewtype();
		$this->saveGetParams($request);
		$this->savePostParams($request);
		
		$api_key = $this->detectApiKey();
		if ($api_key instanceof \ElggApiKey) {
			$this->entity->api_key = $api_key->guid;
		}
	}
	
	/**
	 * Track tha API result
	 *
	 * @param \Elgg\Event $event 'view_vars', 'api/output'
	 *
	 * @return void
	 */
	public function apiOutput(\Elgg\Event $event): void {
		$vars = $event->getValue();
		$result = elgg_extract('result', $vars);
		if (!$result instanceof \GenericResult) {
			return;
		}
		
		$result_data = $result->export();
		
		$this->entity->result_code = $result_data->status;
		$this->entity->success = $result instanceof \SuccessResult;
		$this->entity->response_time = time();
		
		if ($result instanceof \ErrorResult) {
			$this->entity->error_message = $result_data->message;
		}
	}
	
	/**
	 * Find the API key for the current request
	 *
	 * @return \ElggApiKey|null
	 */
	protected function detectApiKey(): ?\ElggApiKey {
		$api_key = (string) get_input('api_key');
		if (empty($api_key)) {
			// try HMAC headers
			$api_key = _elgg_services()->request->server->get('HTTP_X_ELGG_APIKEY');
		}
		
		if (empty($api_key)) {
			return null;
		}
		
		$api_user = _elgg_services()->apiUsersTable->getApiUser($api_key, false);
		if (empty($api_user)) {
			return null;
		}
		
		return elgg_call(ELGG_IGNORE_ACCESS, function() use ($api_key) {
			$entities = elgg_get_entities([
				'type' => 'object',
				'subtype' => \ElggApiKey::SUBTYPE,
				'metadata_name_value_pairs' => [
					'name' => 'public_key',
					'value' => $api_key,
				],
				'limit' => 1,
			]);
			
			return elgg_extract(0, $entities);
		});
	}
	
	/**
	 * Save the GET parameters in the log
	 *
	 * @param \Elgg\Http\Request $request current request
	 *
	 * @return void
	 */
	protected function saveGetParams(\Elgg\Http\Request $request): void {
		$params = $request->query->all();
		unset($params['method']);
		unset($params['api_key']);
		
		if (empty($params)) {
			return;
		}
		
		$this->entity->get_params = json_encode($params);
	}
	
	/**
	 * Save the POST parameters in the log
	 *
	 * @param \Elgg\Http\Request $request current request
	 *
	 * @return void
	 */
	protected function savePostParams(\Elgg\Http\Request $request): void {
		$params = $request->request->all();
		unset($params['method']);
		unset($params['api_key']);
		
		$route = $request->getRoute();
		if ($route instanceof Route) {
			$route_params = $route->getMatchedParameters();
			foreach ($route_params as $key => $value) {
				unset($params[$key]);
			}
			
			unset($params['_route']);
		}
		
		$get_params = $request->query->all();
		foreach ($get_params as $key => $value) {
			unset($params[$key]);
		}
		
		if (empty($params)) {
			return;
		}
		
		$total_length = 0;
		foreach ($params as $key => $value) {
			$value = elgg_get_excerpt($value, 500);
			
			$total_length += elgg_strlen($value);
			
			$params[$key] = $value;
		}
		
		if ($total_length > 10000) {
			$params = [
				'post_size' => 'too large, not saved',
			];
		}
		
		$this->entity->post_params = json_encode($params);
	}
}
