<?php

return [

	/**
	 * Do not any other providers here
	 * these providers will be loaded before checking wether the plugin should exit or not.
	 */

	'services' => [
		'enqueueService' => \Atiqsu\WpPave\Handlers\EnqueueHandler::class,
		'filterService' => \Atiqsu\WpPave\Handlers\FilterHandler::class,
		'actionService' => \Atiqsu\WpPave\Handlers\FilterHandler::class,
		'scriptHandler' => \Atiqsu\WpPave\Handlers\ScriptHandler::class,
		'styleHandler' => \Atiqsu\WpPave\Handlers\StyleHandler::class,
		'adminPageService' => \Atiqsu\WpPave\Handlers\PageServiceHandler::class,
	],
];
