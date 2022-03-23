<?php

return [

	/**
	 * Do not any other providers here
	 * these providers will be loaded before checking wether the plugin should exit or not.
	 */
	'before_boot_providers' => [
		\Atiqsu\WpPave\Providers\AdminNoticeService::class,
	],
];
