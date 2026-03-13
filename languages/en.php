<?php

return [
	'collection:object:webservice_log_entry' => "Webservice log entries",
	'item:object:webservice_log_entry' => "Webservice log entry",
	
	'webservices_logger:settings:retention' => "Keep logs for x days",
	'webservices_logger:settings:retention:help' => "After this time the logs will be deleted",
	'webservices_logger:settings:only_errors' => "Log only errors",
	'webservices_logger:settings:only_errors:help' => "No longer log all requests, only those that failed",
	
	'webservices_logger:menu:admin_header:logs' => "Logs",
	
	'admin:configure_utilities:ws_logs' => "Webservices logs",
	
	'table_columns:fromProperty:api_method' => "API method",
	'table_columns:fromView:api_success' => "Success",
	'table_columns:fromView:api_error_message' => "Error message",
	'table_columns:fromView:api_details' => "Details",
	
	'webservices_logger:log_entry:success' => "Success",
	'webservices_logger:log_entry:error' => "Error",
	
	'webservices_logger:details:request' => "Request",
	'webservices_logger:details:request:time_created' => "Request start time",
	'webservices_logger:details:request:request_method' => "Request method",
	'webservices_logger:details:request:view_type' => "Output format",
	'webservices_logger:details:request:user_agent' => "User agent",
	'webservices_logger:details:request:response_time' => "Response time",
	'webservices_logger:details:request:result_code' => "API result code",
	'webservices_logger:details:request:api_key' => "Used API key",
	'webservices_logger:details:get' => "GET",
	'webservices_logger:details:get:none' => "No GET parameters supplied",
	'webservices_logger:details:post' => "POST",
	'webservices_logger:details:post:none' => "No POST parameters supplied",
];
