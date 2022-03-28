<?php

namespace Atiqsu\WpPave\Contracts;

interface EnqueueInterface {

	/**
	 * Predefined hooks are - admin and front and both
	 *  other possible hooks can be elementor_editor and so on.
	 *
	 * @param string $name - default is admin
	 * @return mixed
	 */
	public function on(string $name = 'admin');

	public function style($path, $options = []);

	public function inlineStyle($data, $handle = '');

	public function script($path, $options = []);

	public function headerScript($path, $options = []);

	public function footerScript($path, $options = []);

	public function localizeScript($handle, $objectName, $data);

	public function inlineScript($data, $option = []);

	public function register($config);

	public function init($config);
}
