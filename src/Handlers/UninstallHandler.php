<?php

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\HandlerInterface;

abstract class UninstallHandler implements HandlerInterface {

	abstract public function uninstall();

	abstract public function clearGlobalSettings();

	abstract public function clearWpCronSchedules();

	public function handle($network_wide = false) {

		$this->uninstall();
		$this->clearGlobalSettings();
		$this->clearWpCronSchedules();

		do_action( 'WpPave/extend/on/after/uninstallation' );
	}
}
