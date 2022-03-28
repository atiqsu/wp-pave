<?php

namespace Atiqsu\WpPave\Handlers;

class EnqueueHandler implements \Atiqsu\WpPave\Contracts\EnqueueInterface {

	/**
	 * @inheritDoc
	 */
	public function on(string $name = 'admin') {
		// TODO: Implement on() method.
	}

	public function style($path, $options = []) {
		// TODO: Implement style() method.
	}

	public function inlineStyle($data, $handle = '') {
		// TODO: Implement inlineStyle() method.
	}

	public function script($path, $options = []) {
		// TODO: Implement script() method.
	}

	public function headerScript($path, $options = []) {
		// TODO: Implement headerScript() method.
	}

	public function footerScript($path, $options = []) {
		// TODO: Implement footerScript() method.
	}

	public function localizeScript($handle, $objectName, $data) {
		// TODO: Implement localizeScript() method.
	}

	public function inlineScript($data, $option = []) {
		// TODO: Implement inlineScript() method.
	}

	public function register($config) {
		// TODO: Implement register() method.
	}

	public function init($config) {
		// TODO: Implement init() method.
	}
}
