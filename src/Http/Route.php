<?php

namespace Atiqsu\WpPave\Http;

class Route {

	private string $namespace;

	public function get($route, $handler) {

		//	public function get('test/{id}') {
	}

	public function post() {

	}

	/**
	 * register is responsible for doing some .
	 *
	 * register_rest_route( string $namespace, string $route, array $args = array(), bool $override = false )
	 * $args['methods']
	 * $args['callback']
	 * $args['permission_callback']
	 * $args['args']
	 * $args['args'][][validate_callback]
	 * $args['args'][][sanitize_callback]
	 *
	 *
	 * @return mixed
	 * @cache - TWQuIEF0aXF1ciBSYWhtYW4!
	 * @author - pavenest solutions
	 * @email - pavenest@gmail.com
	 * @created - 6/4/22 - 12:08 PM
	 *
	 * @praam - cGF2ZW5lc3RAZ21haWwuY29t
	 * @rel - YXRpcXVyLnN1QGdtYWlsLmNvbQ!#
	 *
	 */
	public function register() {

		$uri = '';

		return register_rest_route($this->namespace, "/{$uri}", $this->options);

		register_rest_route('app/v1', '/phone/verify', array('methods' => 'POST', 'callback' => array($this, 'sendVerifyCode'), 'args' => array('phone' => array('validate_callback' => array($this, 'validatePhone')))));
		register_rest_route('app/v1', '/login/phone', array('methods' => 'POST', 'callback' => array($this, 'processLogin'), 'args' => array('phone' => array('validate_callback' => array($this, 'validatePhone')))));
		register_rest_route('app/v1', '/resetpass/phone', array('methods' => 'POST', 'callback' => array($this, 'processResetPassword'), 'args' => array('phone' => array('validate_callback' => array($this, 'validatePhone')))));
		register_rest_route('app/v1', '/register/phone', array('methods' => 'POST', 'callback' => array($this, 'processRegister'), 'args' => array('phone' => array('validate_callback' => array($this, 'validatePhone')))));


		// You can get the combined, merged set of parameters:
		$parameters = $request->get_params();

		// The individual sets of parameters are also available, if needed:
		$parameters = $request->get_url_params();
		$parameters = $request->get_query_params();
		$parameters = $request->get_body_params();
		$parameters = $request->get_json_params();
		$parameters = $request->get_default_params();
		$parameters = $request->get_file_params();

	}

}
