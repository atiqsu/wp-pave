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
	private string $thePolicy = '';
	private string $groupPrefix = '';
	private array $routes = [];
	private Config $conf;


	public function __construct() {
		$this->conf   = Application::getInstance()->get(Config::class);
		$this->restNm = trim($this->conf->get('restNamespace'), '/') .
			'/' . $this->conf->get('apiVersion');
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
		$r = new Route($uri, $handler, $method, $this->restNm);
		$r->setPrefix($this->groupPrefix);
		$r->setPolicy($this->thePolicy);

		return $r;
	}

	public function get(string $uri, string $handler): Route {

		$r = $this->newRoute($uri, $handler, 'GET');

		$this->routes[] = $r;

		return $r;
	}

}
