<?php

namespace Atiqsu\WpPave\Handlers;

abstract class ActivationHandler implements HandlerInterface {

	abstract public function install();

	abstract public function defaultGlobalSettings();

	abstract public function wpCronSchedule();

	public function handle($network_wide = false) {

		$this->install();

		do_action( 'WpPave/extend/on/after/activation' );


		/**
		 * todo - Learning Notes:
		 *
		 *  $cache_plugins = wp_cache_get( 'plugins', 'plugins' );
		 *  do not forget to disable cron from wp-config if you have no cron
		 *  define('DISABLE_WP_CRON', true);
		 *
		 */
	}
}
