<?php

namespace Atiqsu\WpPave\Http;

use Atiqsu\WpPave\Contracts\MiddlewareInterface;

class Route {

	private string $namespace = '';
	private string $uri;
	private array $options = [];
	private array $extra = [];
	private string $httpMethod = 'GET';
	private string $prefix = '';
	private string $policy = '';
	private string $handlerCls;
	private string $handlerMethod;

	//$uri, $handler, $method, $this->restNm

	public function __construct($uri, $handler, $method, $namespace, $nms) {

		$tmp = trim($handler);
		$tmp = explode('@', $tmp);

		$this->handlerCls    = ltrim($nms.$tmp[0]);
		$this->handlerMethod = $tmp[1];

		$this->uri        = '/' . trim($uri, '/');
		$this->namespace  = $namespace;
		$this->httpMethod = $method;

	}

	public function setPrefix($prefix) {
		$this->prefix = $prefix;
	}

	public function setPolicy($policy) {
		$this->policy = $policy;
	}

	public function verifyPermission(\WP_REST_Request $request) {

		if(empty($this->policy)) {
			return true;
		}

		$policy = new $this->policy;

		if($policy instanceof MiddlewareInterface) {

			return $policy->verify($request, $request->get_url_params());
		}

		return '__returnTrue';
	}

	public function handle(\WP_REST_Request $request) {

		$controller = new $this->handlerCls;

		if($controller instanceof Controller) {
			if(method_exists($controller, $this->handlerMethod)) {

				$response = $controller->{$this->handlerMethod}($request, $request->get_url_params());

				//$response instanceof WP_REST_Response

				return $response;
			}


			return new \WP_REST_Response(
				[
					'message' => 'Controller method not found defined in api handler',
				],
				423
			);
		}

		return new \WP_REST_Response(
			[
				'message' => 'Controller must be the instance of the controller class',
			],
			423
		);
	}

	private function compileOpt() {

		$this->options = [
			'args'                => [
				'__extra' => $this->extra,
			],
			'methods'             => $this->httpMethod,
			'callback'            => [$this, 'handle'],
			'permission_callback' => [$this, 'verifyPermission'],
		];

		if(!empty($this->prefix)) {
			$this->uri = '/'.trim($this->prefix). $this->uri;
		}

		//register_rest_route(
		//'app/v1',
		// '/phone/verify',
		// ['methods' => 'POST',
		// 'callback' => [$this, 'sendVerifyCode'],
		// 'args' => ['phone' => ['validate_callback' => [$this, 'validatePhone']]]]);
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
	public function register($debug = false) {

		$this->compileOpt();

		if($debug === true) {
			return [
				$this->uri.'::'. $this->handlerCls.'->'. $this->handlerMethod.'('.$this->options['methods'].')',
				$this->policy,
				site_url().'/wp-json/'.$this->namespace.$this->uri,
			];
		}

		return register_rest_route($this->namespace, $this->uri, $this->options);

		//register_rest_route('app/v1', '/phone/verify', ['methods' => 'POST', 'callback' => [$this, 'sendVerifyCode'], 'args' => ['phone' => ['validate_callback' => [$this, 'validatePhone']]]]);
		//register_rest_route('app/v1', '/login/phone', ['methods' => 'POST', 'callback' => [$this, 'processLogin'], 'args' => ['phone' => ['validate_callback' => [$this, 'validatePhone']]]]);
		//register_rest_route('app/v1', '/resetpass/phone', ['methods' => 'POST', 'callback' => [$this, 'processResetPassword'], 'args' => ['phone' => ['validate_callback' => [$this, 'validatePhone']]]]);
		//register_rest_route('app/v1', '/register/phone', ['methods' => 'POST', 'callback' => [$this, 'processRegister'], 'args' => ['phone' => ['validate_callback' => [$this, 'validatePhone']]]]);


		// You can get the combined, merged set of parameters:
		//$parameters = $request->get_params();

		// The individual sets of parameters are also available, if needed:
		//$parameters = $request->get_url_params();
		//$parameters = $request->get_query_params();
		//$parameters = $request->get_body_params();
		//$parameters = $request->get_json_params();
		//$parameters = $request->get_default_params();
		//$parameters = $request->get_file_params();
	}


}
