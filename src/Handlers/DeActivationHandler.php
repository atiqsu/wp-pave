<?php

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Contracts\HandlerInterface;

abstract class DeActivationHandler implements HandlerInterface {

	abstract public function deactivate();

	abstract public function userConsentToClearData() : bool;

	public function clearDataAndCron() {
		// do nothing here, if developer want to do something in their plugin let it be overridden
	}

	public function handle($network_wide = false) {
		$this->deactivate();

		if($this->userConsentToClearData() === true) {
			$this->clearDataAndCron();
		}

		do_action( 'WpPave/extend/on/after/deactivation' );
	}
}
