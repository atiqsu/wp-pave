<?php
/**
 *
 * @author - pavenest solutions
 * @email - pavenest@gmail.com
 * @created - 4/4/22 - 1:51 PM
 *
 * @cache - TWQuIEF0aXF1ciBSYWhtYW4#
 */

namespace Atiqsu\WpPave\Handlers;

use Atiqsu\WpPave\Config\Config;
use Atiqsu\WpPave\Contracts\RoutingInterface;
use Atiqsu\WpPave\Http\Route;
use Atiqsu\WpPave\System\Application;

class RouterHandler implements RoutingInterface {

	private string $restNm = '';
	private string $controllerNm = '';
	private string $thePolicy = '';
	private string $groupPrefix = '';
	private array $routes = [];
	private Config $conf;


	public function __construct() {
		$this->conf   = Application::getInstance()->get(Config::class);
		$this->restNm = trim($this->conf->get('restNamespace'), '/') .
			'/' . $this->conf->get('apiVersion');
		$this->controllerNm = trim($this->conf->getVal('pluginNamespace'), '/');
	}

	public function group($prefix, \Closure $callback) {

		$this->groupPrefix = $prefix;

		call_user_func($callback, $this);

		$this->groupPrefix = '';
	}

	public function withPolicy($handler): RouterHandler {

		$this->thePolicy = $handler;

		return $this;
	}

	protected function newRoute($uri, $handler, $method): Route {
		$r = new Route($uri, $handler, $method, $this->restNm, $this->controllerNm);
		$r->setPrefix($this->groupPrefix);
		$r->setPolicy($this->thePolicy);

		return $r;
	}

	public function get(string $uri, string $handler): Route {

		$r = $this->newRoute($uri, $handler, 'GET');

		$this->routes[] = $r;

		return $r;
	}

	public function run() {
		$debug = $this->conf->getVal('debug');

		if($debug) {
			$debug = [];
			foreach($this->routes as $route) {
				$debug[] = $route->register(true);
			}

			echo '<pre>';
			print_r($debug);
			echo '</pre>';
			die('ohhh nooooo...');
		}

		foreach($this->routes as $route) {
			$route->register();
		}
	}
}
