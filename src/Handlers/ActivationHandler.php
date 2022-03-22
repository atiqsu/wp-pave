<?php

namespace Atiqsu\WpPave\Handlers;

abstract class ActivationHandler implements HandlerInterface {

	abstract public function install();

	abstract public function defaultGlobalSettings();

	abstract public function wpCronSchedule();

	public function handle() {

		$this->install();

		do_action( 'WpPave/extend/on/after/activation' );
	}
}
