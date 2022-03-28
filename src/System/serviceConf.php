<?php

return [

	/**
	 * Do not any other providers here
	 * these providers will be loaded before checking wether the plugin should exit or not.
	 */

	'services' => [
		'enqueueService' => \Atiqsu\WpPave\Handlers\EnqueueHandler::class,
		'adminPageService' => \Atiqsu\WpPave\Handlers\PageServiceHandler::class,
	],
];
