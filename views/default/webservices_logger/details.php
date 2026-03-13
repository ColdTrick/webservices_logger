<?php
/**
 * Show details about an API request
 *
 * @uses $vars['entity'] the log entry
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \WebserviceLogEntry) {
	return;
}

echo elgg_view('page/components/tabs', [
	'tabs' => [
		[
			'text' => elgg_echo('webservices_logger:details:request'),
			'content' => elgg_view('webservices_logger/details/request', [
				'entity' => $entity,
			]),
			'selected' => true,
		],
		[
			'text' => elgg_echo('webservices_logger:details:get'),
			'content' => elgg_view('webservices_logger/details/get', [
				'entity' => $entity,
			]),
		],
		[
			'text' => elgg_echo('webservices_logger:details:post'),
			'content' => elgg_view('webservices_logger/details/post', [
				'entity' => $entity,
			]),
		],
	],
	'class' => 'webservices-logger-details',
]);
?>
<script type="module">
	import 'jquery';
	
	$(document).on('open', '.elgg-tabs-component.webservices-logger-details .elgg-tabs > li', function() {
		$(window).trigger('resize.lightbox');
	});
	$('#cboxLoadedContent').find('.elgg-menu-navigation-tabs .elgg-components-tab.elgg-state-selected a').trigger('click');
</script>

